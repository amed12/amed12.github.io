import { forwardRef } from 'react';
import PropTypes from 'prop-types';

// ATS-Friendly CV Template following FAANG standards
const CVTemplate = forwardRef(({ data, targetPosition = 'all' }, ref) => {
  if (!data) return null;

  const { profile, skills, languages, experience, projects, education, certifications, honors } = data;

  // Position-specific bio templates
  const bioTemplates = {
    'flutter': `Experienced Mobile Developer specializing in Flutter and Dart with ${profile?.yearsOfExperience || '5+'} years of experience. Proven track record in building cross-platform mobile applications with clean architecture, state management (Riverpod, BLoC), and modern UI/UX practices. Passionate about creating performant, scalable mobile solutions.`,
    'android': `Senior Android Developer with ${profile?.yearsOfExperience || '5+'} years of expertise in native Android development using Kotlin and Java. Specialized in modern Android architecture (MVVM, Clean Architecture), Jetpack Compose, and building high-performance applications. Strong focus on Material Design and user experience.`,
    'ios': `Skilled iOS Developer with ${profile?.yearsOfExperience || '5+'} years of experience in Swift and iOS ecosystem. Expert in SwiftUI, UIKit, and modern iOS development patterns. Committed to delivering polished, user-friendly applications following Apple's Human Interface Guidelines and best practices.`,
    'react-native': `Versatile Mobile Developer specializing in React Native with ${profile?.yearsOfExperience || '5+'} years of experience. Proficient in building cross-platform mobile applications using TypeScript, Redux, and modern React patterns. Strong background in JavaScript ecosystem and mobile app optimization.`,
    'mobile': `Full-Stack Mobile Developer with ${profile?.yearsOfExperience || '5+'} years of experience across multiple platforms (iOS, Android, Flutter, React Native). Versatile in native and cross-platform development, with strong problem-solving skills and commitment to code quality.`,
    'web': `Full-Stack Web Developer with ${profile?.yearsOfExperience || '5+'} years of experience building modern web applications. Expert in React, TypeScript, and modern frontend frameworks. Strong understanding of responsive design, performance optimization, and web accessibility standards.`,
  };

  // Get customized bio or use original
  const customBio = targetPosition !== 'all' && bioTemplates[targetPosition]
    ? bioTemplates[targetPosition]
    : profile?.bio;

  // Position-specific skill priorities
  const skillPriorities = {
    'flutter': ['flutter', 'dart', 'riverpod', 'bloc', 'provider', 'firebase', 'rest api'],
    'android': ['kotlin', 'android', 'java', 'jetpack', 'compose', 'mvvm', 'room', 'retrofit'],
    'ios': ['swift', 'ios', 'swiftui', 'uikit', 'combine', 'core data', 'xcode'],
    'react-native': ['react native', 'typescript', 'javascript', 'redux', 'react', 'expo'],
    'mobile': ['kotlin', 'swift', 'flutter', 'react native', 'android', 'ios', 'mobile'],
    'web': ['react', 'typescript', 'javascript', 'html', 'css', 'tailwind', 'vite', 'node'],
  };

  // Sort skills by relevance to target position
  const sortSkillsByRelevance = (skillsList) => {
    if (!skillsList || targetPosition === 'all') return skillsList;

    const priorities = skillPriorities[targetPosition] || [];
    return [...skillsList].sort((a, b) => {
      const aName = a.name.toLowerCase();
      const bName = b.name.toLowerCase();

      const aScore = priorities.findIndex(p => aName.includes(p));
      const bScore = priorities.findIndex(p => bName.includes(p));

      if (aScore === -1 && bScore === -1) return 0;
      if (aScore === -1) return 1;
      if (bScore === -1) return -1;
      return aScore - bScore;
    });
  };

  // Filter certifications by relevance
  const filterCertifications = (certs) => {
    if (!certs || targetPosition === 'all') return certs;

    const relevantKeywords = skillPriorities[targetPosition] || [];
    const scored = certs.map(cert => {
      const combined = `${cert.title} ${cert.issuer}`.toLowerCase();
      const score = relevantKeywords.filter(kw => combined.includes(kw)).length;
      return { ...cert, score };
    });

    return scored
      .sort((a, b) => b.score - a.score)
      .slice(0, 5); // Top 5 most relevant
  };

  // Group skills by category with sorting
  const sortedSkills = sortSkillsByRelevance(skills);
  const groupedSkills = {
    languages: sortedSkills?.filter(s =>
      ['java', 'kotlin', 'javascript', 'python', 'dart', 'php', 'swift', 'typescript'].some(lang =>
        s.name.toLowerCase().includes(lang)
      )
    ) || [],
    frameworks: sortedSkills?.filter(s =>
      ['react', 'flutter', 'laravel', 'codeigniter', 'bootstrap', 'jquery', 'android', 'swiftui', 'compose'].some(fw =>
        s.name.toLowerCase().includes(fw)
      )
    ) || [],
    tools: sortedSkills?.filter(s =>
      ['git', 'docker', 'firebase', 'aws', 'xcode', 'android studio'].some(tool =>
        s.name.toLowerCase().includes(tool)
      )
    ) || [],
  };

  const filteredCertifications = filterCertifications(certifications);

  // Filter out learning projects from CV
  const productionProjects = projects?.filter(project => !project.learningProject) || [];

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
      {(customBio || profile?.bio) && (
        <div className="mb-6">
          <h2 className="text-base font-bold mb-2 border-b border-gray-600" style={{ fontSize: '12pt' }}>
            PROFESSIONAL SUMMARY
          </h2>
          <p className="text-sm" style={{ fontSize: '10pt' }}>
            {customBio}
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
      {productionProjects && productionProjects.length > 0 && (
        <div className="mb-6">
          <h2 className="text-base font-bold mb-2 border-b border-gray-600" style={{ fontSize: '12pt' }}>
            KEY PROJECTS
          </h2>
          <div className="space-y-3">
            {productionProjects.slice(0, 3).map((project) => (
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
      {filteredCertifications && filteredCertifications.length > 0 && (
        <div className="mb-6">
          <h2 className="text-base font-bold mb-2 border-b border-gray-600" style={{ fontSize: '12pt' }}>
            CERTIFICATIONS
          </h2>
          <div className="space-y-1">
            {filteredCertifications.map((cert) => (
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

CVTemplate.propTypes = {
  data: PropTypes.shape({
    profile: PropTypes.shape({
      name: PropTypes.string,
      phone: PropTypes.string,
      email: PropTypes.string,
      bio: PropTypes.string,
      yearsOfExperience: PropTypes.oneOfType([PropTypes.string, PropTypes.number]),
      social: PropTypes.shape({
        linkedin: PropTypes.string,
        github: PropTypes.string,
      }),
    }),
    skills: PropTypes.arrayOf(
      PropTypes.shape({
        id: PropTypes.oneOfType([PropTypes.string, PropTypes.number]),
        name: PropTypes.string,
        level: PropTypes.string,
      })
    ),
    languages: PropTypes.arrayOf(
      PropTypes.shape({
        name: PropTypes.string,
        level: PropTypes.string,
      })
    ),
    experience: PropTypes.arrayOf(
      PropTypes.shape({
        id: PropTypes.oneOfType([PropTypes.string, PropTypes.number]),
        company: PropTypes.string,
        title: PropTypes.string,
        location: PropTypes.string,
        startDate: PropTypes.string,
        endDate: PropTypes.string,
        description: PropTypes.string,
      })
    ),
    projects: PropTypes.arrayOf(
      PropTypes.shape({
        id: PropTypes.oneOfType([PropTypes.string, PropTypes.number]),
        title: PropTypes.string,
        description: PropTypes.string,
        link: PropTypes.string,
        technologies: PropTypes.arrayOf(PropTypes.string),
        learningProject: PropTypes.bool,
      })
    ),
    education: PropTypes.arrayOf(
      PropTypes.shape({
        id: PropTypes.oneOfType([PropTypes.string, PropTypes.number]),
        school: PropTypes.string,
        degree: PropTypes.string,
        description: PropTypes.string,
        startDate: PropTypes.string,
        endDate: PropTypes.string,
        gpa: PropTypes.string,
      })
    ),
    certifications: PropTypes.arrayOf(
      PropTypes.shape({
        id: PropTypes.oneOfType([PropTypes.string, PropTypes.number]),
        title: PropTypes.string,
        issuer: PropTypes.string,
        date: PropTypes.string,
      })
    ),
    honors: PropTypes.arrayOf(
      PropTypes.shape({
        id: PropTypes.oneOfType([PropTypes.string, PropTypes.number]),
        title: PropTypes.string,
        issuer: PropTypes.string,
        date: PropTypes.string,
      })
    ),
  }),
  targetPosition: PropTypes.string,
};

export default CVTemplate;
