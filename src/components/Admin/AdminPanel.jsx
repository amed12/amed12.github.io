import { useState } from 'react';
import { Save, Download, RotateCcw, X } from 'lucide-react';
import ProfileEditor from './ProfileEditor';
import SkillsEditor from './SkillsEditor';
import ExperienceEditor from './ExperienceEditor';
import ProjectsEditor from './ProjectsEditor';
import EducationEditor from './EducationEditor';
import CertificationsEditor from './CertificationsEditor';
import TestimonialsEditor from './TestimonialsEditor';
import { saveData, downloadData, resetData } from '../../utils/dataManager';

const AdminPanel = ({ data, onDataChange, onClose }) => {
  const [activeTab, setActiveTab] = useState('profile');
  const [localData, setLocalData] = useState(data);
  const [saveStatus, setSaveStatus] = useState('');

  const tabs = [
    { id: 'profile', label: 'Profile' },
    { id: 'skills', label: 'Skills' },
    { id: 'experience', label: 'Experience' },
    { id: 'projects', label: 'Projects' },
    { id: 'education', label: 'Education' },
    { id: 'certifications', label: 'Certifications' },
    { id: 'testimonials', label: 'Testimonials' },
  ];

  const handleSave = () => {
    const success = saveData(localData);
    if (success) {
      setSaveStatus('Saved successfully!');
      onDataChange(localData);
      setTimeout(() => setSaveStatus(''), 3000);
    } else {
      setSaveStatus('Error saving data');
      setTimeout(() => setSaveStatus(''), 3000);
    }
  };

  const handleDownload = () => {
    downloadData(localData);
    setSaveStatus('Data downloaded!');
    setTimeout(() => setSaveStatus(''), 3000);
  };

  const handleReset = async () => {
    if (confirm('Are you sure you want to reset to original data? This will discard all changes.')) {
      const originalData = await resetData();
      if (originalData) {
        setLocalData(originalData);
        onDataChange(originalData);
        setSaveStatus('Data reset to original!');
        setTimeout(() => setSaveStatus(''), 3000);
      }
    }
  };

  const updateData = (section, value) => {
    setLocalData((prev) => ({
      ...prev,
      [section]: value,
    }));
  };

  return (
    <div className="fixed inset-0 bg-black bg-opacity-50 z-50 overflow-y-auto">
      <div className="min-h-screen p-4">
        <div className="max-w-6xl mx-auto bg-white rounded-lg shadow-2xl my-8">
          {/* Header */}
          <div className="border-b border-gray-200 p-6">
            <div className="flex items-center justify-between mb-4">
              <h1 className="text-3xl font-bold text-gray-900">Admin Panel</h1>
              <button
                onClick={onClose}
                className="text-gray-500 hover:text-gray-700 transition-colors"
              >
                <X className="w-6 h-6" />
              </button>
            </div>

            {/* Action Buttons */}
            <div className="flex flex-wrap gap-3">
              <button onClick={handleSave} className="btn-primary flex items-center gap-2">
                <Save className="w-4 h-4" />
                Save Changes
              </button>
              <button onClick={handleDownload} className="btn-secondary flex items-center gap-2">
                <Download className="w-4 h-4" />
                Download JSON
              </button>
              <button
                onClick={handleReset}
                className="bg-red-100 hover:bg-red-200 text-red-700 font-semibold py-2 px-4 rounded-lg transition-colors flex items-center gap-2"
              >
                <RotateCcw className="w-4 h-4" />
                Reset to Original
              </button>
              {saveStatus && (
                <div className="flex items-center px-4 py-2 bg-green-100 text-green-700 rounded-lg">
                  {saveStatus}
                </div>
              )}
            </div>
          </div>

          {/* Tabs */}
          <div className="border-b border-gray-200 overflow-x-auto">
            <div className="flex">
              {tabs.map((tab) => (
                <button
                  key={tab.id}
                  onClick={() => setActiveTab(tab.id)}
                  className={`px-6 py-3 font-medium transition-colors whitespace-nowrap ${
                    activeTab === tab.id
                      ? 'border-b-2 border-primary-600 text-primary-600'
                      : 'text-gray-600 hover:text-gray-900'
                  }`}
                >
                  {tab.label}
                </button>
              ))}
            </div>
          </div>

          {/* Content */}
          <div className="p-6">
            {activeTab === 'profile' && (
              <ProfileEditor
                profile={localData.profile}
                onChange={(value) => updateData('profile', value)}
              />
            )}
            {activeTab === 'skills' && (
              <SkillsEditor
                skills={localData.skills}
                onChange={(value) => updateData('skills', value)}
              />
            )}
            {activeTab === 'experience' && (
              <ExperienceEditor
                experience={localData.experience}
                onChange={(value) => updateData('experience', value)}
              />
            )}
            {activeTab === 'projects' && (
              <ProjectsEditor
                projects={localData.projects}
                onChange={(value) => updateData('projects', value)}
              />
            )}
            {activeTab === 'education' && (
              <EducationEditor
                education={localData.education}
                onChange={(value) => updateData('education', value)}
              />
            )}
            {activeTab === 'certifications' && (
              <CertificationsEditor
                certifications={localData.certifications}
                onChange={(value) => updateData('certifications', value)}
              />
            )}
            {activeTab === 'testimonials' && (
              <TestimonialsEditor
                testimonials={localData.testimonials}
                onChange={(value) => updateData('testimonials', value)}
              />
            )}
          </div>
        </div>
      </div>
    </div>
  );
};

export default AdminPanel;
