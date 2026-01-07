import { useRef, useState, useMemo } from 'react';
import { useNavigate } from 'react-router-dom';
import { Download, ArrowLeft, Printer, Briefcase } from 'lucide-react';
import CVTemplate from '../components/CV/CVTemplate';
import jsPDF from 'jspdf';
import html2canvas from 'html2canvas';

const CVPage = ({ data }) => {
  const cvRef = useRef();
  const navigate = useNavigate();
  const [targetPosition, setTargetPosition] = useState('all');

  const handleDownloadPDF = async () => {
    if (!cvRef.current) return;

    try {
      // Show loading state
      const button = document.getElementById('download-btn');
      if (button) {
        button.disabled = true;
        button.textContent = 'Generating PDF...';
      }

      // Capture the CV as canvas
      const canvas = await html2canvas(cvRef.current, {
        scale: 2,
        useCORS: true,
        logging: false,
        backgroundColor: '#ffffff',
      });

      // Calculate dimensions for Letter size (8.5 x 11 inches)
      const imgWidth = 210; // A4 width in mm (close to Letter)
      const imgHeight = (canvas.height * imgWidth) / canvas.width;

      // Create PDF
      const pdf = new jsPDF({
        orientation: 'portrait',
        unit: 'mm',
        format: 'a4',
      });

      const imgData = canvas.toDataURL('image/png');
      pdf.addImage(imgData, 'PNG', 0, 0, imgWidth, imgHeight);

      // Download
      const fileName = `${data?.profile?.name?.replace(/\s+/g, '_') || 'CV'}_Resume.pdf`;
      pdf.save(fileName);

      // Reset button
      if (button) {
        button.disabled = false;
        button.textContent = 'Download PDF';
      }
    } catch (error) {
      console.error('Error generating PDF:', error);
      alert('Error generating PDF. Please try again.');
    }
  };

  const handlePrint = () => {
    window.print();
  };

  // Position options with their relevant technologies
  const positionOptions = [
    { value: 'all', label: 'All Projects (General)', keywords: [] },
    { value: 'flutter', label: 'Flutter Developer', keywords: ['flutter', 'dart', 'riverpod', 'bloc'] },
    { value: 'android', label: 'Android Developer', keywords: ['kotlin', 'android', 'java', 'jetpack'] },
    { value: 'ios', label: 'iOS Developer', keywords: ['swift', 'ios', 'swiftui', 'uikit', 'combine'] },
    { value: 'react-native', label: 'React Native Developer', keywords: ['react native', 'react-native', 'typescript', 'redux'] },
    { value: 'mobile', label: 'Mobile Developer (General)', keywords: ['mobile', 'kotlin', 'swift', 'flutter', 'react native'] },
    { value: 'web', label: 'Web Developer', keywords: ['react', 'javascript', 'typescript', 'web', 'vite', 'tailwind'] },
  ];

  // Filter and sort projects based on target position
  const filteredData = useMemo(() => {
    if (!data) return null;
    if (targetPosition === 'all') return data;

    const selectedPosition = positionOptions.find(p => p.value === targetPosition);
    if (!selectedPosition) return data;

    // Filter projects based on relevance
    const scoredProjects = data.projects?.map(project => {
      const techString = project.technologies?.join(' ').toLowerCase() || '';
      const title = project.title.toLowerCase();
      const description = project.description.toLowerCase();
      const combined = `${techString} ${title} ${description}`;

      // Calculate relevance score
      let score = 0;
      selectedPosition.keywords.forEach(keyword => {
        if (combined.includes(keyword.toLowerCase())) {
          score += 1;
        }
      });

      return { ...project, relevanceScore: score };
    }) || [];

    // Sort by relevance and take top projects
    const sortedProjects = scoredProjects
      .filter(p => p.relevanceScore > 0)
      .sort((a, b) => b.relevanceScore - a.relevanceScore);

    // If no relevant projects found, show all
    const finalProjects = sortedProjects.length > 0 ? sortedProjects : data.projects;

    return {
      ...data,
      projects: finalProjects
    };
  }, [data, targetPosition]);

  if (!data) {
    return (
      <div className="min-h-screen flex items-center justify-center">
        <div className="text-center">
          <div className="animate-spin rounded-full h-16 w-16 border-b-2 border-primary-600 mx-auto mb-4"></div>
          <p className="text-gray-600">Loading CV...</p>
        </div>
      </div>
    );
  }

  return (
    <div className="min-h-screen bg-gray-100">
      {/* Action Bar - Hidden in print */}
      <div className="bg-white shadow-md sticky top-0 z-10 print:hidden">
        <div className="container mx-auto px-4 py-4">
          <div className="flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
            <button
              onClick={() => navigate('/')}
              className="flex items-center gap-2 text-gray-600 hover:text-gray-900 transition-colors"
            >
              <ArrowLeft className="w-5 h-5" />
              Back to Portfolio
            </button>

            {/* Position Selector */}
            <div className="flex items-center gap-3 flex-1 md:flex-initial md:max-w-md">
              <Briefcase className="w-5 h-5 text-gray-600 flex-shrink-0" />
              <select
                value={targetPosition}
                onChange={(e) => setTargetPosition(e.target.value)}
                className="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent text-sm"
              >
                {positionOptions.map(option => (
                  <option key={option.value} value={option.value}>
                    {option.label}
                  </option>
                ))}
              </select>
            </div>

            <div className="flex gap-3">
              <button
                onClick={handlePrint}
                className="btn-secondary flex items-center gap-2"
              >
                <Printer className="w-4 h-4" />
                Print
              </button>
              <button
                id="download-btn"
                onClick={handleDownloadPDF}
                className="btn-primary flex items-center gap-2"
              >
                <Download className="w-4 h-4" />
                Download PDF
              </button>
            </div>
          </div>
        </div>
      </div>

      {/* CV Preview */}
      <div className="container mx-auto py-8 print:p-0">
        {/* Position Info Banner */}
        {targetPosition !== 'all' && (
          <div className="bg-primary-50 border border-primary-200 rounded-lg p-4 mb-4 print:hidden">
            <div className="flex items-start gap-3">
              <Briefcase className="w-5 h-5 text-primary-600 mt-0.5 flex-shrink-0" />
              <div>
                <h3 className="font-semibold text-primary-900 mb-1">
                  CV Optimized for: {positionOptions.find(p => p.value === targetPosition)?.label}
                </h3>
                <p className="text-sm text-primary-800 mb-2">
                  Your CV has been automatically customized for this position:
                </p>
                <ul className="text-sm text-primary-800 list-disc list-inside space-y-1">
                  <li><strong>Professional Summary:</strong> Tailored to highlight relevant experience</li>
                  <li><strong>Technical Skills:</strong> Sorted by relevance (most important first)</li>
                  <li><strong>Key Projects:</strong> Top 3 most relevant projects displayed</li>
                  <li><strong>Certifications:</strong> Filtered to show only relevant credentials</li>
                </ul>
              </div>
            </div>
          </div>
        )}
        
        <div className="bg-white shadow-lg print:shadow-none">
          <CVTemplate ref={cvRef} data={filteredData} targetPosition={targetPosition} />
        </div>
      </div>

      {/* Instructions - Hidden in print */}
      <div className="container mx-auto px-4 pb-8 print:hidden">
        <div className="grid md:grid-cols-2 gap-4">
          {/* Position Selector Info */}
          <div className="bg-green-50 border border-green-200 rounded-lg p-6">
            <h3 className="font-bold text-green-900 mb-2">🎯 Smart Position Targeting</h3>
            <p className="text-green-800 text-sm mb-3">
              Use the position selector above to automatically optimize your CV for specific roles:
            </p>
            <ul className="text-green-800 text-sm space-y-1 list-disc list-inside">
              <li><strong>Professional Summary:</strong> Auto-generated bio emphasizing relevant expertise</li>
              <li><strong>Technical Skills:</strong> Reordered to show most relevant skills first</li>
              <li><strong>Key Projects:</strong> Top 3 most relevant projects based on tech stack</li>
              <li><strong>Certifications:</strong> Filtered to show only position-relevant credentials</li>
            </ul>
            <p className="text-green-800 text-sm mt-3 font-semibold">
              💡 Tip: Select the position you're applying for before downloading to maximize ATS score!
            </p>
          </div>

          {/* ATS Format Info */}
          <div className="bg-blue-50 border border-blue-200 rounded-lg p-6">
            <h3 className="font-bold text-blue-900 mb-2">📋 ATS-Friendly CV Format</h3>
            <p className="text-blue-800 text-sm mb-3">
              This CV is formatted according to FAANG/Big Tech company standards and is optimized for
              Applicant Tracking Systems (ATS).
            </p>
            <ul className="text-blue-800 text-sm space-y-1 list-disc list-inside">
              <li>Clean, professional layout with standard fonts</li>
              <li>Reverse chronological order for experience</li>
              <li>Quantifiable achievements and action verbs</li>
              <li>Keywords optimized for tech positions</li>
              <li>One-page format (recommended for most positions)</li>
            </ul>
          </div>
        </div>
      </div>

      {/* Print Styles */}
      <style>{`
        @media print {
          body {
            margin: 0;
            padding: 0;
          }
          @page {
            margin: 0.5in;
            size: letter;
          }
        }
      `}</style>
    </div>
  );
};

export default CVPage;
