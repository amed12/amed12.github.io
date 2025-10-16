import { GraduationCap, Calendar } from 'lucide-react';

const Education = ({ education }) => {
  if (!education || education.length === 0) return null;

  return (
    <section className="py-16 bg-white">
      <div className="container mx-auto px-4">
        <h2 className="text-3xl font-bold mb-12 text-center">Education</h2>
        <div className="max-w-4xl mx-auto space-y-6">
          {education.map((edu) => (
            <div key={edu.id} className="card hover:shadow-lg transition-shadow">
              <div className="flex items-start gap-4">
                <div className="w-12 h-12 bg-primary-100 rounded-lg flex items-center justify-center flex-shrink-0">
                  <GraduationCap className="w-6 h-6 text-primary-600" />
                </div>
                <div className="flex-1">
                  <h3 className="text-xl font-bold text-gray-900 mb-1">{edu.degree}</h3>
                  <p className="text-primary-600 font-medium mb-2">{edu.school}</p>
                  <div className="flex items-center gap-2 text-sm text-gray-500 mb-2">
                    <Calendar className="w-4 h-4" />
                    <span>
                      {edu.startDate} - {edu.endDate}
                    </span>
                  </div>
                  {edu.gpa && (
                    <p className="text-gray-700 mb-2">
                      <span className="font-semibold">GPA:</span> {edu.gpa}
                    </p>
                  )}
                  {edu.description && <p className="text-gray-600">{edu.description}</p>}
                </div>
              </div>
            </div>
          ))}
        </div>
      </div>
    </section>
  );
};

export default Education;
