import { useState } from 'react';
import { ExternalLink, Code2 } from 'lucide-react';

const Projects = ({ projects }) => {
  const [filter, setFilter] = useState('all');

  if (!projects || projects.length === 0) return null;

  const categories = ['all', ...new Set(projects.map((p) => p.category))];
  const filteredProjects = filter === 'all' ? projects : projects.filter((p) => p.category === filter);

  return (
    <section className="py-16 bg-gray-50">
      <div className="container mx-auto px-4">
        <h2 className="text-3xl font-bold mb-8 text-center">Projects</h2>

        {/* Filter Buttons */}
        <div className="flex flex-wrap justify-center gap-3 mb-12">
          {categories.map((category) => (
            <button
              key={category}
              onClick={() => setFilter(category)}
              className={`px-6 py-2 rounded-full font-medium transition-all ${
                filter === category
                  ? 'bg-primary-600 text-white shadow-md'
                  : 'bg-white text-gray-700 hover:bg-gray-100'
              }`}
            >
              {category.charAt(0).toUpperCase() + category.slice(1)}
            </button>
          ))}
        </div>

        {/* Projects Grid */}
        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 max-w-7xl mx-auto">
          {filteredProjects.map((project) => (
            <div
              key={project.id}
              className="card hover:shadow-xl transition-all duration-300 flex flex-col"
            >
              {/* Project Image */}
              <div className="w-full h-48 bg-gray-200 rounded-lg mb-4 overflow-hidden">
                <img
                  src={project.image || '/project-placeholder.png'}
                  alt={project.title}
                  className="w-full h-full object-cover hover:scale-105 transition-transform duration-300"
                  onError={(e) => {
                    e.target.src = 'https://via.placeholder.com/400x300/0ea5e9/ffffff?text=Project';
                  }}
                />
              </div>

              {/* Project Info */}
              <h3 className="text-xl font-bold mb-2">{project.title}</h3>
              <p className="text-gray-600 text-sm mb-4 flex-1">{project.description}</p>

              {/* Technologies */}
              <div className="flex flex-wrap gap-2 mb-4">
                {project.technologies?.slice(0, 3).map((tech, idx) => (
                  <span
                    key={idx}
                    className="text-xs bg-primary-50 text-primary-700 px-2 py-1 rounded"
                  >
                    {tech}
                  </span>
                ))}
                {project.technologies?.length > 3 && (
                  <span className="text-xs bg-gray-100 text-gray-600 px-2 py-1 rounded">
                    +{project.technologies.length - 3} more
                  </span>
                )}
              </div>

              {/* Link */}
              {project.link && (
                <a
                  href={project.link}
                  target="_blank"
                  rel="noopener noreferrer"
                  className="inline-flex items-center gap-2 text-primary-600 hover:text-primary-700 font-medium"
                >
                  <ExternalLink className="w-4 h-4" />
                  View Project
                </a>
              )}
            </div>
          ))}
        </div>
      </div>
    </section>
  );
};

export default Projects;
