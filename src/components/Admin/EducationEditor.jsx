import { Plus, Trash2 } from 'lucide-react';

const EducationEditor = ({ education, onChange }) => {
  const addEducation = () => {
    const newEdu = {
      id: `edu${Date.now()}`,
      degree: '',
      school: '',
      startDate: '',
      endDate: '',
      gpa: '',
      description: '',
    };
    onChange([...education, newEdu]);
  };

  const removeEducation = (id) => {
    onChange(education.filter((edu) => edu.id !== id));
  };

  const updateEducation = (id, field, value) => {
    const updated = education.map((edu) =>
      edu.id === id ? { ...edu, [field]: value } : edu
    );
    onChange(updated);
  };

  return (
    <div className="space-y-6">
      <div className="flex items-center justify-between">
        <h2 className="text-2xl font-bold">Education</h2>
        <button onClick={addEducation} className="btn-primary flex items-center gap-2">
          <Plus className="w-4 h-4" />
          Add Education
        </button>
      </div>

      <div className="space-y-6">
        {education.map((edu) => (
          <div key={edu.id} className="card">
            <div className="flex items-start justify-between mb-4">
              <h3 className="text-lg font-semibold">Education Entry</h3>
              <button
                onClick={() => removeEducation(edu.id)}
                className="text-red-600 hover:text-red-700"
              >
                <Trash2 className="w-5 h-5" />
              </button>
            </div>

            <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
              <div>
                <label className="block text-sm font-medium text-gray-700 mb-2">Degree</label>
                <input
                  type="text"
                  value={edu.degree}
                  onChange={(e) => updateEducation(edu.id, 'degree', e.target.value)}
                  className="input-field"
                  placeholder="Bachelor of Science"
                />
              </div>

              <div>
                <label className="block text-sm font-medium text-gray-700 mb-2">School</label>
                <input
                  type="text"
                  value={edu.school}
                  onChange={(e) => updateEducation(edu.id, 'school', e.target.value)}
                  className="input-field"
                />
              </div>

              <div>
                <label className="block text-sm font-medium text-gray-700 mb-2">
                  Start Date
                </label>
                <input
                  type="text"
                  value={edu.startDate}
                  onChange={(e) => updateEducation(edu.id, 'startDate', e.target.value)}
                  className="input-field"
                  placeholder="2014"
                />
              </div>

              <div>
                <label className="block text-sm font-medium text-gray-700 mb-2">End Date</label>
                <input
                  type="text"
                  value={edu.endDate}
                  onChange={(e) => updateEducation(edu.id, 'endDate', e.target.value)}
                  className="input-field"
                  placeholder="2019"
                />
              </div>

              <div>
                <label className="block text-sm font-medium text-gray-700 mb-2">GPA</label>
                <input
                  type="text"
                  value={edu.gpa}
                  onChange={(e) => updateEducation(edu.id, 'gpa', e.target.value)}
                  className="input-field"
                  placeholder="3.64/4.00"
                />
              </div>

              <div className="md:col-span-2">
                <label className="block text-sm font-medium text-gray-700 mb-2">
                  Description
                </label>
                <textarea
                  value={edu.description}
                  onChange={(e) => updateEducation(edu.id, 'description', e.target.value)}
                  className="input-field"
                  rows="2"
                />
              </div>
            </div>
          </div>
        ))}
      </div>
    </div>
  );
};

export default EducationEditor;
