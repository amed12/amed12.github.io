import { Plus, Trash2, X } from 'lucide-react';

const ProjectsEditor = ({ projects, onChange }) => {
  const addProject = () => {
    const newProject = {
      id: `proj${Date.now()}`,
      title: '',
      category: 'mobile',
      description: '',
      image: '',
      link: '',
      technologies: [],
    };
    onChange([...projects, newProject]);
  };

  const removeProject = (id) => {
    onChange(projects.filter((proj) => proj.id !== id));
  };

  const updateProject = (id, field, value) => {
    const updated = projects.map((proj) =>
      proj.id === id ? { ...proj, [field]: value } : proj
    );
    onChange(updated);
  };

  const addTechnology = (id) => {
    const updated = projects.map((proj) =>
      proj.id === id ? { ...proj, technologies: [...(proj.technologies || []), ''] } : proj
    );
    onChange(updated);
  };

  const updateTechnology = (projectId, techIndex, value) => {
    const updated = projects.map((proj) => {
      if (proj.id === projectId) {
        const newTechs = [...proj.technologies];
        newTechs[techIndex] = value;
        return { ...proj, technologies: newTechs };
      }
      return proj;
    });
    onChange(updated);
  };

  const removeTechnology = (projectId, techIndex) => {
    const updated = projects.map((proj) => {
      if (proj.id === projectId) {
        return {
          ...proj,
          technologies: proj.technologies.filter((_, i) => i !== techIndex),
        };
      }
      return proj;
    });
    onChange(updated);
  };

  return (
    <div className="space-y-6">
      <div className="flex items-center justify-between">
        <h2 className="text-2xl font-bold">Projects</h2>
        <button onClick={addProject} className="btn-primary flex items-center gap-2">
          <Plus className="w-4 h-4" />
          Add Project
        </button>
      </div>

      <div className="space-y-6">
        {projects.map((project) => (
          <div key={project.id} className="card">
            <div className="flex items-start justify-between mb-4">
              <h3 className="text-lg font-semibold">Project Entry</h3>
              <button
                onClick={() => removeProject(project.id)}
                className="text-red-600 hover:text-red-700"
              >
                <Trash2 className="w-5 h-5" />
              </button>
            </div>

            <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
              <div>
                <label className="block text-sm font-medium text-gray-700 mb-2">
                  Project Title
                </label>
                <input
                  type="text"
                  value={project.title}
                  onChange={(e) => updateProject(project.id, 'title', e.target.value)}
                  className="input-field"
                />
              </div>

              <div>
                <label className="block text-sm font-medium text-gray-700 mb-2">Category</label>
                <select
                  value={project.category}
                  onChange={(e) => updateProject(project.id, 'category', e.target.value)}
                  className="input-field"
                >
                  <option value="mobile">Mobile</option>
                  <option value="web">Web</option>
                  <option value="desktop">Desktop</option>
                  <option value="other">Other</option>
                </select>
              </div>

              <div>
                <label className="block text-sm font-medium text-gray-700 mb-2">
                  Image URL
                </label>
                <input
                  type="text"
                  value={project.image}
                  onChange={(e) => updateProject(project.id, 'image', e.target.value)}
                  className="input-field"
                  placeholder="/projects/image.png"
                />
              </div>

              <div>
                <label className="block text-sm font-medium text-gray-700 mb-2">
                  Project Link
                </label>
                <input
                  type="text"
                  value={project.link}
                  onChange={(e) => updateProject(project.id, 'link', e.target.value)}
                  className="input-field"
                  placeholder="https://..."
                />
              </div>

              <div className="md:col-span-2">
                <label className="block text-sm font-medium text-gray-700 mb-2">
                  Description
                </label>
                <textarea
                  value={project.description}
                  onChange={(e) => updateProject(project.id, 'description', e.target.value)}
                  className="input-field"
                  rows="3"
                />
              </div>

              <div className="md:col-span-2">
                <div className="flex items-center justify-between mb-2">
                  <label className="block text-sm font-medium text-gray-700">Technologies</label>
                  <button
                    onClick={() => addTechnology(project.id)}
                    className="text-primary-600 hover:text-primary-700 text-sm font-medium"
                  >
                    + Add Technology
                  </button>
                </div>
                <div className="space-y-2">
                  {project.technologies?.map((tech, techIndex) => (
                    <div key={techIndex} className="flex items-center gap-2">
                      <input
                        type="text"
                        value={tech}
                        onChange={(e) =>
                          updateTechnology(project.id, techIndex, e.target.value)
                        }
                        className="input-field"
                        placeholder="Technology name"
                      />
                      <button
                        onClick={() => removeTechnology(project.id, techIndex)}
                        className="text-red-600 hover:text-red-700 p-2"
                      >
                        <X className="w-4 h-4" />
                      </button>
                    </div>
                  ))}
                </div>
              </div>
            </div>
          </div>
        ))}
      </div>
    </div>
  );
};

export default ProjectsEditor;
