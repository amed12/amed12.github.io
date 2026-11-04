import { useRef, useState, useMemo } from 'react';
import { useNavigate } from 'react-router-dom';
import PropTypes from 'prop-types';
import { Download, ArrowLeft, Printer, Briefcase, Share2 } from 'lucide-react';
import CVTemplate from '../components/CV/CVTemplate';
import jsPDF from 'jspdf';
import { POSITION_OPTIONS } from '../config/positions';
import { filterProjectsByPosition } from '../utils/cvScoring';

const PAGE_WIDTH = 210; // A4, mm
const MARGIN = 15;
const CONTENT_WIDTH = PAGE_WIDTH - MARGIN * 2;
const PAGE_HEIGHT = 297; // A4, mm

const CVPage = ({ data }) => {
  const cvRef = useRef();
  const navigate = useNavigate();
  const [targetPosition, setTargetPosition] = useState('all');

  const handleDownloadPDF = async () => {
    if (!data) return;

    try {
      const button = document.getElementById('download-btn');
      if (button) {
        button.disabled = true;
        button.textContent = 'Generating PDF...';
      }

      const pdf = new jsPDF({ orientation: 'portrait', unit: 'mm', format: 'a4' });
      let y = MARGIN;

      const ensureSpace = (needed) => {
        if (y + needed > PAGE_HEIGHT - MARGIN) {
          pdf.addPage();
          y = MARGIN;
        }
      };

      const addHeading = (text) => {
        ensureSpace(10);
        pdf.setFont('helvetica', 'bold');
        pdf.setFontSize(11);
        pdf.text(text, MARGIN, y);
        y += 1.5;
        pdf.setLineWidth(0.2);
        pdf.line(MARGIN, y, MARGIN + CONTENT_WIDTH, y);
        y += 5;
        pdf.setFont('helvetica', 'normal');
      };

      const addParagraph = (text, { fontSize = 10, bold = false, italic = false } = {}) => {
        pdf.setFont('helvetica', bold ? 'bold' : italic ? 'italic' : 'normal');
        pdf.setFontSize(fontSize);
        const lines = pdf.splitTextToSize(text, CONTENT_WIDTH);
        lines.forEach((line) => {
          ensureSpace(5);
          pdf.text(line, MARGIN, y);
          y += 5;
        });
      };

      const addBullets = (items) => {
        pdf.setFont('helvetica', 'normal');
        pdf.setFontSize(10);
        items.forEach((item) => {
          const trimmed = item.trim();
          if (!trimmed) return;
          const cleaned = trimmed.replace(/^\d+\.\s*/, '').replace(/^-\s*/, '');
          const lines = pdf.splitTextToSize(`• ${cleaned}`, CONTENT_WIDTH - 4);
          lines.forEach((line) => {
            ensureSpace(5);
            pdf.text(line, MARGIN + 4, y);
            y += 5;
          });
        });
        y += 1;
      };

      const { profile, skills, languages, experience, projects, education, certifications, honors } = data;

      // Header
      pdf.setFont('helvetica', 'bold');
      pdf.setFontSize(18);
      pdf.text(profile?.name?.toUpperCase() || '', MARGIN, y);
      y += 7;
      const contactLine = [
        profile?.phone,
        profile?.email,
        profile?.social?.linkedin?.replace(/^https?:\/\//, ''),
        profile?.social?.github?.replace(/^https?:\/\//, ''),
      ].filter(Boolean).join('  |  ');
      addParagraph(contactLine, { fontSize: 9.5 });
      y += 1;
      pdf.setLineWidth(0.4);
      pdf.line(MARGIN, y, MARGIN + CONTENT_WIDTH, y);
      y += 6;

      // Professional summary
      const bio = (targetPosition !== 'all' && profile?.positionSummaries?.[targetPosition])
        || profile?.bio;
      if (bio) {
        addHeading('PROFESSIONAL SUMMARY');
        addParagraph(bio);
        y += 3;
      }

      // Skills
      if (skills?.length) {
        addHeading('TECHNICAL SKILLS');
        addParagraph(skills.map((s) => s.name).join(', '));
        y += 3;
      }

      // Experience
      if (experience?.length) {
        addHeading('PROFESSIONAL EXPERIENCE');
        experience.forEach((exp) => {
          ensureSpace(10);
          addParagraph(`${exp.company}${exp.location ? `, ${exp.location}` : ''}  (${exp.startDate} - ${exp.endDate})`, { bold: true });
          addParagraph(exp.title, { italic: true });
          addBullets(exp.description.split('\n'));
        });
        y += 2;
      }

      // Projects (top 3, matching on-screen CVTemplate behavior)
      const productionProjects = (projects || []).filter((p) => !p.learningProject);
      if (productionProjects.length) {
        addHeading('KEY PROJECTS');
        productionProjects.slice(0, 3).forEach((project) => {
          addParagraph(project.title, { bold: true });
          addParagraph(project.description);
          if (project.technologies?.length) {
            addParagraph(`Technologies: ${project.technologies.slice(0, 5).join(', ')}`, { fontSize: 9 });
          }
          y += 2;
        });
      }

      // Education
      if (education?.length) {
        addHeading('EDUCATION');
        education.forEach((edu) => {
          addParagraph(`${edu.school}${edu.description ? `, ${edu.description}` : ''}  (${edu.startDate} - ${edu.endDate})`, { bold: true });
          addParagraph(`${edu.degree}${edu.gpa ? ` | GPA: ${edu.gpa}` : ''}`);
        });
        y += 2;
      }

      // Certifications
      if (certifications?.length) {
        addHeading('CERTIFICATIONS');
        certifications.forEach((cert) => {
          addParagraph(`${cert.title} | ${cert.issuer} | ${cert.date}`);
        });
        y += 2;
      }

      // Honors
      if (honors?.length) {
        addHeading('HONORS & AWARDS');
        honors.forEach((honor) => {
          addParagraph(`${honor.title} | ${honor.issuer} | ${honor.date}`);
        });
        y += 2;
      }

      // Languages
      if (languages?.length) {
        addHeading('LANGUAGES');
        addParagraph(languages.map((l) => `${l.name} (${l.level})`).join('  |  '));
      }

      const fileName = `${profile?.name?.replace(/\s+/g, '_') || 'CV'}_Resume.pdf`;
      pdf.save(fileName);

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

  // Filter and sort projects based on target position
  const filteredData = useMemo(() => {
    if (!data) return null;
    if (targetPosition === 'all') return data;

    return {
      ...data,
      projects: filterProjectsByPosition(data.projects, targetPosition),
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
                {POSITION_OPTIONS.map(option => (
                  <option key={option.value} value={option.value}>
                    {option.label}
                  </option>
                ))}
              </select>
            </div>

            <div className="flex gap-3">
              <button
                onClick={() => navigate('/share')}
                className="btn-secondary flex items-center gap-2"
              >
                <Share2 className="w-4 h-4" />
                Share
              </button>
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
                  CV Optimized for: {POSITION_OPTIONS.find(p => p.value === targetPosition)?.label}
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
              💡 Tip: Select the position you&apos;re applying for before downloading to maximize ATS score!
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
            size: a4;
          }
        }
      `}</style>
    </div>
  );
};

CVPage.propTypes = {
  data: PropTypes.shape({
    profile: PropTypes.shape({
      name: PropTypes.string,
      phone: PropTypes.string,
      email: PropTypes.string,
      bio: PropTypes.string,
      positionSummaries: PropTypes.objectOf(PropTypes.string),
      social: PropTypes.shape({
        linkedin: PropTypes.string,
        github: PropTypes.string,
      }),
    }),
    skills: PropTypes.arrayOf(PropTypes.shape({ name: PropTypes.string })),
    languages: PropTypes.arrayOf(PropTypes.shape({ name: PropTypes.string, level: PropTypes.string })),
    experience: PropTypes.arrayOf(PropTypes.shape({
      id: PropTypes.oneOfType([PropTypes.string, PropTypes.number]),
      company: PropTypes.string,
      location: PropTypes.string,
      title: PropTypes.string,
      startDate: PropTypes.string,
      endDate: PropTypes.string,
      description: PropTypes.string,
    })),
    projects: PropTypes.arrayOf(PropTypes.shape({
      id: PropTypes.oneOfType([PropTypes.string, PropTypes.number]),
      title: PropTypes.string,
      description: PropTypes.string,
      technologies: PropTypes.arrayOf(PropTypes.string),
      learningProject: PropTypes.bool,
    })),
    education: PropTypes.arrayOf(PropTypes.shape({
      id: PropTypes.oneOfType([PropTypes.string, PropTypes.number]),
      school: PropTypes.string,
      description: PropTypes.string,
      degree: PropTypes.string,
      gpa: PropTypes.string,
      startDate: PropTypes.string,
      endDate: PropTypes.string,
    })),
    certifications: PropTypes.arrayOf(PropTypes.shape({
      id: PropTypes.oneOfType([PropTypes.string, PropTypes.number]),
      title: PropTypes.string,
      issuer: PropTypes.string,
      date: PropTypes.string,
    })),
    honors: PropTypes.arrayOf(PropTypes.shape({
      id: PropTypes.oneOfType([PropTypes.string, PropTypes.number]),
      title: PropTypes.string,
      issuer: PropTypes.string,
      date: PropTypes.string,
    })),
  }),
};

export default CVPage;
