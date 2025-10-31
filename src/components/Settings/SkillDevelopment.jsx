import { useState, useEffect } from 'react';
import { TrendingUp, Target, BookOpen, Award, Clock, CheckCircle } from 'lucide-react';
import { getSkills, updateSkillProgress } from '../../utils/storageManager';

const SkillDevelopment = () => {
  const [skills, setSkills] = useState(getSkills());

  const handleProgressChange = (skillId, newProgress) => {
    const updated = updateSkillProgress(skillId, parseInt(newProgress));
    setSkills(updated);
  };

  const skillsArray = Object.values(skills);
  const totalProgress = skillsArray.reduce((sum, skill) => sum + skill.progress, 0);
  const avgProgress = Math.round(totalProgress / skillsArray.length);
  const completedSkills = skillsArray.filter(s => s.progress >= 100).length;

  const getStatusColor = (progress) => {
    if (progress >= 100) return 'text-green-600 bg-green-100';
    if (progress >= 50) return 'text-blue-600 bg-blue-100';
    if (progress > 0) return 'text-yellow-600 bg-yellow-100';
    return 'text-gray-600 bg-gray-100';
  };

  const getProgressColor = (progress) => {
    if (progress >= 100) return 'bg-green-500';
    if (progress >= 50) return 'bg-blue-500';
    if (progress > 0) return 'bg-yellow-500';
    return 'bg-gray-300';
  };

  return (
    <div className="space-y-6">
      {/* Header */}
      <div>
        <h1 className="text-3xl font-bold text-gray-900">Skill Development</h1>
        <p className="text-gray-600 mt-2">Track your learning progress and skill improvements</p>
      </div>

      {/* Stats Overview */}
      <div className="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div className="bg-white rounded-xl p-6 border border-gray-200">
          <div className="flex items-center justify-between mb-2">
            <span className="text-gray-600">Average Progress</span>
            <TrendingUp className="w-5 h-5 text-primary-600" />
          </div>
          <div className="text-3xl font-bold text-gray-900">{avgProgress}%</div>
          <div className="text-sm text-gray-500 mt-1">Across all skills</div>
        </div>

        <div className="bg-white rounded-xl p-6 border border-gray-200">
          <div className="flex items-center justify-between mb-2">
            <span className="text-gray-600">Completed</span>
            <CheckCircle className="w-5 h-5 text-green-600" />
          </div>
          <div className="text-3xl font-bold text-gray-900">{completedSkills}/{skillsArray.length}</div>
          <div className="text-sm text-gray-500 mt-1">Skills mastered</div>
        </div>

        <div className="bg-white rounded-xl p-6 border border-gray-200">
          <div className="flex items-center justify-between mb-2">
            <span className="text-gray-600">In Progress</span>
            <Clock className="w-5 h-5 text-blue-600" />
          </div>
          <div className="text-3xl font-bold text-gray-900">
            {skillsArray.filter(s => s.progress > 0 && s.progress < 100).length}
          </div>
          <div className="text-sm text-gray-500 mt-1">Currently learning</div>
        </div>

        <div className="bg-white rounded-xl p-6 border border-gray-200">
          <div className="flex items-center justify-between mb-2">
            <span className="text-gray-600">Not Started</span>
            <Target className="w-5 h-5 text-gray-600" />
          </div>
          <div className="text-3xl font-bold text-gray-900">
            {skillsArray.filter(s => s.progress === 0).length}
          </div>
          <div className="text-sm text-gray-500 mt-1">To begin</div>
        </div>
      </div>

      {/* Skills by Category */}
      <div className="space-y-6">
        {['Testing', 'Performance'].map(category => {
          const categorySkills = skillsArray.filter(s => s.category === category);
          if (categorySkills.length === 0) return null;

          return (
            <div key={category} className="bg-white rounded-xl p-6 border border-gray-200">
              <h2 className="text-xl font-bold text-gray-900 mb-4">{category} Skills</h2>
              <div className="space-y-4">
                {categorySkills.map(skill => (
                  <div key={skill.id} className="space-y-3">
                    <div className="flex items-start justify-between">
                      <div className="flex-1">
                        <div className="flex items-center gap-3">
                          <h3 className="font-semibold text-gray-900">{skill.name}</h3>
                          <span className={`px-2 py-1 rounded-full text-xs font-medium ${
                            skill.priority === 'high' ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700'
                          }`}>
                            {skill.priority} priority
                          </span>
                          <span className={`px-2 py-1 rounded-full text-xs font-medium ${getStatusColor(skill.progress)}`}>
                            {skill.progress >= 100 ? 'Completed' : skill.progress > 0 ? 'In Progress' : 'Not Started'}
                          </span>
                        </div>
                        {skill.resources && skill.resources.length > 0 && (
                          <div className="flex items-center gap-2 mt-2">
                            <BookOpen className="w-4 h-4 text-gray-400" />
                            <span className="text-sm text-gray-600">
                              Resources: {skill.resources.join(', ')}
                            </span>
                          </div>
                        )}
                      </div>
                      <div className="text-right ml-4">
                        <div className="text-2xl font-bold text-gray-900">{skill.progress}%</div>
                      </div>
                    </div>

                    {/* Progress Bar */}
                    <div className="space-y-2">
                      <div className="w-full bg-gray-200 rounded-full h-3">
                        <div 
                          className={`h-3 rounded-full transition-all duration-300 ${getProgressColor(skill.progress)}`}
                          style={{ width: `${skill.progress}%` }}
                        />
                      </div>
                      
                      {/* Progress Slider */}
                      <div className="flex items-center gap-4">
                        <input
                          type="range"
                          min="0"
                          max="100"
                          step="5"
                          value={skill.progress}
                          onChange={(e) => handleProgressChange(skill.id, e.target.value)}
                          className="flex-1 h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer accent-primary-600"
                        />
                        <input
                          type="number"
                          min="0"
                          max="100"
                          value={skill.progress}
                          onChange={(e) => handleProgressChange(skill.id, e.target.value)}
                          className="w-20 px-3 py-1 border border-gray-300 rounded-lg text-center focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                        />
                      </div>
                    </div>

                    {skill.lastUpdated && (
                      <div className="text-xs text-gray-500">
                        Last updated: {new Date(skill.lastUpdated).toLocaleDateString()}
                      </div>
                    )}
                  </div>
                ))}
              </div>
            </div>
          );
        })}
      </div>

      {/* Learning Tips */}
      <div className="bg-gradient-to-br from-primary-50 to-primary-100 rounded-xl p-6 border border-primary-200">
        <div className="flex items-start gap-4">
          <div className="p-3 bg-white rounded-lg">
            <Award className="w-6 h-6 text-primary-600" />
          </div>
          <div className="flex-1">
            <h2 className="text-xl font-bold text-primary-900 mb-2">Learning Tips</h2>
            <div className="grid grid-cols-1 md:grid-cols-2 gap-3 text-sm text-primary-800">
              <div className="flex items-start gap-2">
                <CheckCircle className="w-4 h-4 text-primary-600 mt-0.5 flex-shrink-0" />
                <span>Focus on high-priority skills first (UI Automator, Espresso)</span>
              </div>
              <div className="flex items-start gap-2">
                <CheckCircle className="w-4 h-4 text-primary-600 mt-0.5 flex-shrink-0" />
                <span>Dedicate 1-2 hours daily for consistent progress</span>
              </div>
              <div className="flex items-start gap-2">
                <CheckCircle className="w-4 h-4 text-primary-600 mt-0.5 flex-shrink-0" />
                <span>Build small projects to practice each skill</span>
              </div>
              <div className="flex items-start gap-2">
                <CheckCircle className="w-4 h-4 text-primary-600 mt-0.5 flex-shrink-0" />
                <span>Update progress weekly to track improvements</span>
              </div>
            </div>
          </div>
        </div>
      </div>

      {/* Skill Roadmap */}
      <div className="bg-white rounded-xl p-6 border border-gray-200">
        <h2 className="text-xl font-bold text-gray-900 mb-4">Recommended Learning Path</h2>
        <div className="space-y-4">
          <div className="flex items-start gap-4">
            <div className="flex flex-col items-center">
              <div className="w-8 h-8 rounded-full bg-red-100 text-red-600 flex items-center justify-center font-bold">1</div>
              <div className="w-0.5 h-12 bg-gray-300"></div>
            </div>
            <div className="flex-1 pb-4">
              <h3 className="font-semibold text-gray-900">UI Automator (High Priority)</h3>
              <p className="text-sm text-gray-600 mt-1">Essential for automated testing - Required by Grab Android</p>
              <div className="text-xs text-gray-500 mt-1">Estimated time: 2-3 weeks</div>
            </div>
          </div>

          <div className="flex items-start gap-4">
            <div className="flex flex-col items-center">
              <div className="w-8 h-8 rounded-full bg-red-100 text-red-600 flex items-center justify-center font-bold">2</div>
              <div className="w-0.5 h-12 bg-gray-300"></div>
            </div>
            <div className="flex-1 pb-4">
              <h3 className="font-semibold text-gray-900">Espresso Advanced (High Priority)</h3>
              <p className="text-sm text-gray-600 mt-1">Deep dive into advanced testing patterns</p>
              <div className="text-xs text-gray-500 mt-1">Estimated time: 2 weeks</div>
            </div>
          </div>

          <div className="flex items-start gap-4">
            <div className="flex flex-col items-center">
              <div className="w-8 h-8 rounded-full bg-yellow-100 text-yellow-600 flex items-center justify-center font-bold">3</div>
              <div className="w-0.5 h-12 bg-gray-300"></div>
            </div>
            <div className="flex-1 pb-4">
              <h3 className="font-semibold text-gray-900">Perfetto (Medium Priority)</h3>
              <p className="text-sm text-gray-600 mt-1">Performance profiling tool - Required by ASTRO</p>
              <div className="text-xs text-gray-500 mt-1">Estimated time: 1-2 weeks</div>
            </div>
          </div>

          <div className="flex items-start gap-4">
            <div className="flex flex-col items-center">
              <div className="w-8 h-8 rounded-full bg-yellow-100 text-yellow-600 flex items-center justify-center font-bold">4</div>
            </div>
            <div className="flex-1">
              <h3 className="font-semibold text-gray-900">Systrace (Medium Priority)</h3>
              <p className="text-sm text-gray-600 mt-1">System-level performance analysis</p>
              <div className="text-xs text-gray-500 mt-1">Estimated time: 1 week</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
};

export default SkillDevelopment;
