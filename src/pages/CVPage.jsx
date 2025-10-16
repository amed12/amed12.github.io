import { useRef } from 'react';
import { useNavigate } from 'react-router-dom';
import { Download, ArrowLeft, Printer } from 'lucide-react';
import CVTemplate from '../components/CV/CVTemplate';
import jsPDF from 'jspdf';
import html2canvas from 'html2canvas';

const CVPage = ({ data }) => {
  const cvRef = useRef();
  const navigate = useNavigate();

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
          <div className="flex items-center justify-between">
            <button
              onClick={() => navigate('/')}
              className="flex items-center gap-2 text-gray-600 hover:text-gray-900 transition-colors"
            >
              <ArrowLeft className="w-5 h-5" />
              Back to Portfolio
            </button>

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
        <div className="bg-white shadow-lg print:shadow-none">
          <CVTemplate ref={cvRef} data={data} />
        </div>
      </div>

      {/* Instructions - Hidden in print */}
      <div className="container mx-auto px-4 pb-8 print:hidden">
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
