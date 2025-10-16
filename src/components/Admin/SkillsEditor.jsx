import { Plus, Trash2 } from 'lucide-react';

const SkillsEditor = ({ skills, onChange }) => {
  const addSkill = () => {
    onChange([...skills, { name: '', level: 50 }]);
  };

  const removeSkill = (index) => {
    onChange(skills.filter((_, i) => i !== index));
  };

  const updateSkill = (index, field, value) => {
    const updated = skills.map((skill, i) =>
      i === index ? { ...skill, [field]: value } : skill
    );
    onChange(updated);
  };

  return (
    <div className="space-y-6">
      <div className="flex items-center justify-between">
        <h2 className="text-2xl font-bold">Skills</h2>
        <button onClick={addSkill} className="btn-primary flex items-center gap-2">
          <Plus className="w-4 h-4" />
          Add Skill
        </button>
      </div>

      <div className="space-y-4">
        {skills.map((skill, index) => (
          <div key={index} className="card flex items-center gap-4">
            <div className="flex-1 grid grid-cols-1 md:grid-cols-2 gap-4">
              <div>
                <label className="block text-sm font-medium text-gray-700 mb-2">
                  Skill Name
                </label>
                <input
                  type="text"
                  value={skill.name}
                  onChange={(e) => updateSkill(index, 'name', e.target.value)}
                  className="input-field"
                  placeholder="e.g., React, Python, etc."
                />
              </div>

              <div>
                <label className="block text-sm font-medium text-gray-700 mb-2">
                  Level ({skill.level}%)
                </label>
                <input
                  type="range"
                  min="0"
                  max="100"
                  value={skill.level}
                  onChange={(e) => updateSkill(index, 'level', parseInt(e.target.value))}
                  className="w-full"
                />
              </div>
            </div>

            <button
              onClick={() => removeSkill(index)}
              className="text-red-600 hover:text-red-700 p-2"
            >
              <Trash2 className="w-5 h-5" />
            </button>
          </div>
        ))}
      </div>
    </div>
  );
};

export default SkillsEditor;
