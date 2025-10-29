import { forwardRef } from 'react';

// ATS-Friendly CV Template following FAANG standards
const CVTemplate = forwardRef(({ data }, ref) => {
  if (!data) return null;

  const { profile, skills, languages, experience, projects, education, certifications, honors } = data;

  // Group skills by category
  const groupedSkills = {
    languages: skills?.filter(s => 
      ['java', 'kotlin', 'javascript', 'python', 'dart', 'php'].some(lang => 
        s.name.toLowerCase().includes(lang)
      )
    ) || [],
    frameworks: skills?.filter(s => 
      ['react', 'flutter', 'laravel', 'codeigniter', 'bootstrap', 'jquery', 'android'].some(fw => 
        s.name.toLowerCase().includes(fw)
      )
    ) || [],
    tools: skills?.filter(s => 
      ['git', 'docker', 'firebase', 'aws'].some(tool => 
        s.name.toLowerCase().includes(tool)
      )
    ) || [],
  };

  return (
    <div
      ref={ref}
      className="bg-white p-12 max-w-[8.5in] mx-auto"
      style={{
        fontFamily: 'Arial, sans-serif',
        fontSize: '11pt',
        lineHeight: '1.4',
        color: '#000000',
      }}
    >
      {/* Header - Contact Information */}
      <div className="text-center mb-6 border-b-2 border-gray-800 pb-4">
        <h1 className="text-2xl font-bold mb-2" style={{ fontSize: '20pt' }}>
          {profile?.name?.toUpperCase()}
        </h1>
        <div className="text-sm" style={{ fontSize: '10pt' }}>
          {profile?.phone} | {profile?.email}
          {profile?.social?.linkedin && (
            <> | LinkedIn: {profile.social.linkedin.replace('https://', '').replace('http://', '')}</>
          )}
          {profile?.social?.github && (
            <> | GitHub: {profile.social.github.replace('https://', '').replace('http://', '')}</>
          )}
        </div>
      </div>

      {/* Professional Summary */}
      {profile?.bio && (
        <div className="mb-6">
          <h2 className="text-base font-bold mb-2 border-b border-gray-600" style={{ fontSize: '12pt' }}>
            PROFESSIONAL SUMMARY
          </h2>
          <p className="text-sm" style={{ fontSize: '10pt' }}>
            {profile.bio}
          </p>
        </div>
      )}

      {/* Skills */}
      {skills && skills.length > 0 && (
        <div className="mb-6">
          <h2 className="text-base font-bold mb-2 border-b border-gray-600" style={{ fontSize: '12pt' }}>
            TECHNICAL SKILLS
          </h2>
          <div className="text-sm space-y-1" style={{ fontSize: '10pt' }}>
            {groupedSkills.languages.length > 0 && (
              <div>
                <span className="font-semibold">Programming Languages:</span>{' '}
                {groupedSkills.languages.map(s => s.name).join(', ')}
              </div>
            )}
            {groupedSkills.frameworks.length > 0 && (
              <div>
                <span className="font-semibold">Frameworks & Libraries:</span>{' '}
                {groupedSkills.frameworks.map(s => s.name).join(', ')}
              </div>
            )}
            {groupedSkills.tools.length > 0 && (
              <div>
                <span className="font-semibold">Tools & Technologies:</span>{' '}
                {groupedSkills.tools.map(s => s.name).join(', ')}
              </div>
            )}
            {/* Add remaining skills */}
            {skills.filter(s => 
              !groupedSkills.languages.includes(s) && 
              !groupedSkills.frameworks.includes(s) && 
              !groupedSkills.tools.includes(s)
            ).length > 0 && (
              <div>
                <span className="font-semibold">Other:</span>{' '}
                {skills.filter(s => 
                  !groupedSkills.languages.includes(s) && 
                  !groupedSkills.frameworks.includes(s) && 
                  !groupedSkills.tools.includes(s)
                ).map(s => s.name).join(', ')}
              </div>
            )}
          </div>
        </div>
      )}

      {/* Work Experience */}
      {experience && experience.length > 0 && (
        <div className="mb-6">
          <h2 className="text-base font-bold mb-2 border-b border-gray-600" style={{ fontSize: '12pt' }}>
            PROFESSIONAL EXPERIENCE
          </h2>
          <div className="space-y-4">
            {experience.map((exp) => (
              <div key={exp.id} className="text-sm" style={{ fontSize: '10pt' }}>
                <div className="flex justify-between items-start mb-1">
                  <div>
                    <span className="font-bold">{exp.company}</span>
                    {exp.location && <span>, {exp.location}</span>}
                  </div>
                  <span className="text-gray-700">
                    {exp.startDate} - {exp.endDate}
                  </span>
                </div>
                <div className="italic mb-1">{exp.title}</div>
                <ul className="list-disc list-inside space-y-1 ml-2">
                  {exp.description.split('\n').map((line, idx) => (
                    line.trim() && (
                      <li key={idx} className="ml-2">
                        {line.replace(/^\d+\.\s*/, '').replace(/^-\s*/, '')}
                      </li>
                    )
                  ))}
                </ul>
              </div>
            ))}
          </div>
        </div>
      )}

      {/* Projects */}
      {projects && projects.length > 0 && (
        <div className="mb-6">
          <h2 className="text-base font-bold mb-2 border-b border-gray-600" style={{ fontSize: '12pt' }}>
            KEY PROJECTS
          </h2>
          <div className="space-y-3">
            {projects.slice(0, 3).map((project) => (
              <div key={project.id} className="text-sm" style={{ fontSize: '10pt' }}>
                <div className="font-bold">
                  {project.title}
                  {project.link && (
                    <span className="font-normal text-gray-700"> | {project.link}</span>
                  )}
                </div>
                <p className="mb-1">{project.description}</p>
                {project.technologies && project.technologies.length > 0 && (
                  <div className="text-gray-700">
                    <span className="font-semibold">Technologies:</span>{' '}
                    {project.technologies.slice(0, 5).join(', ')}
                  </div>
                )}
              </div>
            ))}
          </div>
        </div>
      )}

      {/* Education */}
      {education && education.length > 0 && (
        <div className="mb-6">
          <h2 className="text-base font-bold mb-2 border-b border-gray-600" style={{ fontSize: '12pt' }}>
            EDUCATION
          </h2>
          <div className="space-y-2">
            {education.map((edu) => (
              <div key={edu.id} className="text-sm" style={{ fontSize: '10pt' }}>
                <div className="flex justify-between items-start">
                  <div>
                    <span className="font-bold">{edu.school}</span>
                    {edu.description && <span>, {edu.description}</span>}
                  </div>
                  <span className="text-gray-700">
                    {edu.startDate} - {edu.endDate}
                  </span>
                </div>
                <div>
                  {edu.degree}
                  {edu.gpa && <span> | GPA: {edu.gpa}</span>}
                </div>
              </div>
            ))}
          </div>
        </div>
      )}

      {/* Certifications */}
      {certifications && certifications.length > 0 && (
        <div className="mb-6">
          <h2 className="text-base font-bold mb-2 border-b border-gray-600" style={{ fontSize: '12pt' }}>
            CERTIFICATIONS
          </h2>
          <div className="space-y-1">
            {certifications.map((cert) => (
              <div key={cert.id} className="text-sm" style={{ fontSize: '10pt' }}>
                <span className="font-semibold">{cert.title}</span> | {cert.issuer} | {cert.date}
              </div>
            ))}
          </div>
        </div>
      )}

      {/* Honors & Awards */}
      {honors && honors.length > 0 && (
        <div className="mb-6">
          <h2 className="text-base font-bold mb-2 border-b border-gray-600" style={{ fontSize: '12pt' }}>
            HONORS & AWARDS
          </h2>
          <div className="space-y-1">
            {honors.map((honor) => (
              <div key={honor.id} className="text-sm" style={{ fontSize: '10pt' }}>
                <span className="font-semibold">{honor.title}</span> | {honor.issuer} | {honor.date}
              </div>
            ))}
          </div>
        </div>
      )}

      {/* Languages */}
      {languages && languages.length > 0 && (
        <div className="mb-6">
          <h2 className="text-base font-bold mb-2 border-b border-gray-600" style={{ fontSize: '12pt' }}>
            LANGUAGES
          </h2>
          <div className="text-sm" style={{ fontSize: '10pt' }}>
            {languages.map((lang, idx) => (
              <span key={idx}>
                {lang.name} ({lang.level}){idx < languages.length - 1 ? ' | ' : ''}
              </span>
            ))}
          </div>
        </div>
      )}
    </div>
  );
});

CVTemplate.displayName = 'CVTemplate';

export default CVTemplate;
