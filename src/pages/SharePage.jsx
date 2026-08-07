import { useMemo, useState } from 'react';
import { useNavigate, useSearchParams } from 'react-router-dom';
import PropTypes from 'prop-types';
import { ArrowLeft, Briefcase, Copy, Check, FileText, Printer } from 'lucide-react';
import { POSITION_OPTIONS } from '../config/positions';
import { filterProjectsByPositions } from '../utils/cvScoring';
import { sortSkillsByRelevance } from '../utils/cvTemplateHelpers';

const SELECTABLE_POSITIONS = POSITION_OPTIONS.filter((p) => p.value !== 'all');
const VALID_VALUES = SELECTABLE_POSITIONS.map((p) => p.value);

const parsePositions = (searchParams) => {
  const raw = searchParams.get('positions');
  if (!raw) return [];
  return [...new Set(raw.split(',').map((v) => v.trim()).filter((v) => VALID_VALUES.includes(v)))];
};

const SharePage = ({ data }) => {
  const navigate = useNavigate();
  const [searchParams, setSearchParams] = useSearchParams();
  const [copied, setCopied] = useState(false);

  const selectedPositions = useMemo(() => parsePositions(searchParams), [searchParams]);

  const profile = data?.profile;
  const skills = data?.skills;
  const projects = data?.projects;

  // Bio: prefer the first selected position with a written summary, else the general bio.
  const bio = useMemo(() => {
    for (const value of selectedPositions) {
      const summary = profile?.positionSummaries?.[value];
      if (summary) return summary;
    }
    return profile?.bio;
  }, [profile, selectedPositions]);

  const sortedSkills = useMemo(
    () => (skills ? sortSkillsByRelevance(skills, selectedPositions[0] ?? 'all') : skills),
    [skills, selectedPositions]
  );

  const curatedProjects = useMemo(
    () => filterProjectsByPositions(projects, selectedPositions),
    [projects, selectedPositions]
  );

  const togglePosition = (value) => {
    const next = selectedPositions.includes(value)
      ? selectedPositions.filter((v) => v !== value)
      : [...selectedPositions, value];

    if (next.length) {
      setSearchParams({ positions: next.join(',') });
    } else {
      setSearchParams({});
    }
  };

  const handlePrint = () => {
    window.print();
  };

  const handleCopyLink = async () => {
    try {
      await navigator.clipboard.writeText(window.location.href);
      setCopied(true);
      setTimeout(() => setCopied(false), 2000);
    } catch (error) {
      console.error('Failed to copy link:', error);
    }
  };

  if (!data) {
    return (
      <div className="min-h-screen flex items-center justify-center">
        <div className="text-center">
          <div className="animate-spin rounded-full h-16 w-16 border-b-2 border-primary-600 mx-auto mb-4"></div>
          <p className="text-gray-600">Loading...</p>
        </div>
      </div>
    );
  }

  return (
    <div className="min-h-screen bg-gray-100">
      <div className="bg-white shadow-md sticky top-0 z-10 print:hidden">
        <div className="container mx-auto px-4 py-4 flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
          <button
            onClick={() => navigate('/')}
            className="flex items-center gap-2 text-gray-600 hover:text-gray-900 transition-colors"
          >
            <ArrowLeft className="w-5 h-5" />
            Back to Portfolio
          </button>

          <div className="flex gap-3">
            <button onClick={() => navigate('/cv')} className="btn-secondary flex items-center gap-2">
              <FileText className="w-4 h-4" />
              View CV
            </button>
            {selectedPositions.length > 0 && (
              <button onClick={handlePrint} className="btn-secondary flex items-center gap-2">
                <Printer className="w-4 h-4" />
                Print
              </button>
            )}
            <button onClick={handleCopyLink} className="btn-primary flex items-center gap-2">
              {copied ? <Check className="w-4 h-4" /> : <Copy className="w-4 h-4" />}
              {copied ? 'Copied!' : 'Copy Link'}
            </button>
          </div>
        </div>
      </div>

      <div className="container mx-auto px-4 py-8 max-w-4xl print:p-0 print:max-w-none">
        {/* Builder: position picker, always visible so selection can be adjusted */}
        <div className="bg-white rounded-lg shadow p-6 mb-6 print:hidden">
          <h2 className="font-bold text-gray-900 mb-1 flex items-center gap-2">
            <Briefcase className="w-5 h-5 text-primary-600" />
            Select positions to share
          </h2>
          <p className="text-sm text-gray-600 mb-4">
            Choose one or more positions to build a curated, shareable portfolio link.
          </p>
          <div className="flex flex-wrap gap-2">
            {SELECTABLE_POSITIONS.map((option) => {
              const active = selectedPositions.includes(option.value);
              return (
                <button
                  key={option.value}
                  onClick={() => togglePosition(option.value)}
                  className={`px-4 py-2 rounded-lg text-sm border transition-colors ${
                    active
                      ? 'bg-primary-600 border-primary-600 text-white'
                      : 'bg-white border-gray-300 text-gray-700 hover:border-primary-400'
                  }`}
                >
                  {option.label}
                </button>
              );
            })}
          </div>
        </div>

        {selectedPositions.length === 0 ? (
          <div className="bg-blue-50 border border-blue-200 rounded-lg p-6 text-blue-900 text-sm print:hidden">
            Select at least one position above to preview the curated portfolio and get a shareable link.
          </div>
        ) : (
          <div className="bg-white rounded-lg shadow p-6 space-y-8 print:shadow-none">
            {/* Header */}
            <div>
              <div className="flex flex-wrap gap-2 mb-3">
                {selectedPositions.map((value) => (
                  <span
                    key={value}
                    className="px-3 py-1 rounded-full text-xs font-semibold bg-primary-100 text-primary-800"
                  >
                    {SELECTABLE_POSITIONS.find((p) => p.value === value)?.label}
                  </span>
                ))}
              </div>
              <h1 className="text-2xl font-bold text-gray-900">{profile?.name}</h1>
              {bio && <p className="text-gray-700 mt-2 leading-relaxed">{bio}</p>}
            </div>

            {/* Skills */}
            {sortedSkills?.length > 0 && (
              <div>
                <h2 className="font-bold text-gray-900 mb-3 border-b pb-1">Skills</h2>
                <div className="flex flex-wrap gap-2">
                  {sortedSkills.map((skill) => (
                    <span
                      key={skill.name}
                      className="px-3 py-1 rounded-full text-xs bg-gray-100 text-gray-700"
                    >
                      {skill.name}
                    </span>
                  ))}
                </div>
              </div>
            )}

            {/* Projects */}
            {curatedProjects?.length > 0 && (
              <div>
                <h2 className="font-bold text-gray-900 mb-3 border-b pb-1">Projects</h2>
                <div className="space-y-4">
                  {curatedProjects.map((project) => (
                    <div key={project.id ?? project.title}>
                      <h3 className="font-semibold text-gray-900">{project.title}</h3>
                      <p className="text-sm text-gray-700">{project.description}</p>
                      {project.technologies?.length > 0 && (
                        <p className="text-xs text-gray-500 mt-1">
                          {project.technologies.join(', ')}
                        </p>
                      )}
                    </div>
                  ))}
                </div>
              </div>
            )}
          </div>
        )}
      </div>

      <style>{`
        @media print {
          body {
            margin: 0;
            padding: 0;
          }
          @page {
            margin: 0.5in;
            size: a4;
          }
        }
      `}</style>
    </div>
  );
};

SharePage.propTypes = {
  data: PropTypes.shape({
    profile: PropTypes.shape({
      name: PropTypes.string,
      bio: PropTypes.string,
      positionSummaries: PropTypes.objectOf(PropTypes.string),
    }),
    skills: PropTypes.arrayOf(PropTypes.shape({ name: PropTypes.string })),
    projects: PropTypes.arrayOf(PropTypes.shape({
      id: PropTypes.oneOfType([PropTypes.string, PropTypes.number]),
      title: PropTypes.string,
      description: PropTypes.string,
      technologies: PropTypes.arrayOf(PropTypes.string),
    })),
  }),
};

export default SharePage;
