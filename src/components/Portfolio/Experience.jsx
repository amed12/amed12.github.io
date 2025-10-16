import { Briefcase, Calendar } from 'lucide-react';

const Experience = ({ experience }) => {
  if (!experience || experience.length === 0) return null;

  return (
    <section className="py-16 bg-white">
      <div className="container mx-auto px-4">
        <h2 className="text-3xl font-bold mb-12 text-center">Work Experience</h2>
        <div className="max-w-4xl mx-auto space-y-8">
          {experience.map((exp) => (
            <div key={exp.id} className="card hover:shadow-lg transition-shadow">
              <div className="flex items-start gap-4">
                <div className="w-12 h-12 bg-primary-100 rounded-lg flex items-center justify-center flex-shrink-0">
                  <Briefcase className="w-6 h-6 text-primary-600" />
                </div>
                <div className="flex-1">
                  <h3 className="text-xl font-bold text-gray-900 mb-1">{exp.title}</h3>
                  <p className="text-primary-600 font-medium mb-2">
                    {exp.company} {exp.location && `• ${exp.location}`}
                  </p>
                  <div className="flex items-center gap-2 text-sm text-gray-500 mb-3">
                    <Calendar className="w-4 h-4" />
                    <span>
                      {exp.startDate} - {exp.endDate}
                    </span>
                  </div>
                  <p className="text-gray-700 whitespace-pre-line">{exp.description}</p>
                </div>
              </div>
            </div>
          ))}
        </div>
      </div>
    </section>
  );
};

export default Experience;
