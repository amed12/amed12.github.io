import { BookOpen, Video, FileText, ExternalLink, Star, Clock } from 'lucide-react';

const LearningResources = () => {
  const resources = {
    testing: [
      {
        title: 'UI Automator Documentation',
        type: 'docs',
        url: 'https://developer.android.com/training/testing/other-components/ui-automator',
        description: 'Official Android documentation for UI Automator framework',
        difficulty: 'Intermediate',
        duration: '2-3 hours',
        priority: 'high'
      },
      {
        title: 'Espresso Testing Guide',
        type: 'docs',
        url: 'https://developer.android.com/training/testing/espresso',
        description: 'Complete guide to Espresso testing framework',
        difficulty: 'Beginner',
        duration: '3-4 hours',
        priority: 'high'
      },
      {
        title: 'Android Testing Codelab',
        type: 'course',
        url: 'https://developer.android.com/codelabs/advanced-android-kotlin-training-testing-basics',
        description: 'Hands-on codelab for Android testing basics',
        difficulty: 'Beginner',
        duration: '2 hours',
        priority: 'high'
      },
      {
        title: 'Complete Android Testing Course',
        type: 'video',
        url: 'https://www.udemy.com/course/android-testing/',
        description: 'Comprehensive Udemy course on Android testing',
        difficulty: 'All Levels',
        duration: '10 hours',
        priority: 'medium'
      }
    ],
    performance: [
      {
        title: 'Perfetto Documentation',
        type: 'docs',
        url: 'https://perfetto.dev/docs/',
        description: 'Official Perfetto performance profiling documentation',
        difficulty: 'Advanced',
        duration: '4-5 hours',
        priority: 'medium'
      },
      {
        title: 'Android Performance Patterns',
        type: 'video',
        url: 'https://www.youtube.com/playlist?list=PLWz5rJ2EKKc9CBxr3BVjPTPoDPLdPIFCE',
        description: 'YouTube series on Android performance optimization',
        difficulty: 'Intermediate',
        duration: '5 hours',
        priority: 'medium'
      },
      {
        title: 'Systrace Walkthrough',
        type: 'docs',
        url: 'https://developer.android.com/topic/performance/tracing',
        description: 'Guide to using Systrace for performance analysis',
        difficulty: 'Intermediate',
        duration: '2 hours',
        priority: 'medium'
      }
    ],
    architecture: [
      {
        title: 'Clean Architecture Guide',
        type: 'article',
        url: 'https://blog.cleancoder.com/uncle-bob/2012/08/13/the-clean-architecture.html',
        description: 'Uncle Bob\'s original Clean Architecture article',
        difficulty: 'Intermediate',
        duration: '1 hour',
        priority: 'low'
      },
      {
        title: 'Android Architecture Components',
        type: 'docs',
        url: 'https://developer.android.com/topic/architecture',
        description: 'Official guide to Android app architecture',
        difficulty: 'Intermediate',
        duration: '3 hours',
        priority: 'low'
      }
    ],
    flutter: [
      {
        title: 'BLoC Pattern Documentation',
        type: 'docs',
        url: 'https://bloclibrary.dev/',
        description: 'Official BLoC pattern library documentation',
        difficulty: 'Intermediate',
        duration: '3-4 hours',
        priority: 'high'
      },
      {
        title: 'Flutter Testing Guide',
        type: 'docs',
        url: 'https://docs.flutter.dev/testing',
        description: 'Complete guide to testing Flutter applications',
        difficulty: 'Beginner',
        duration: '2 hours',
        priority: 'medium'
      }
    ]
  };

  const getTypeIcon = (type) => {
    switch (type) {
      case 'video': return <Video className="w-5 h-5" />;
      case 'course': return <BookOpen className="w-5 h-5" />;
      case 'docs': return <FileText className="w-5 h-5" />;
      case 'article': return <FileText className="w-5 h-5" />;
      default: return <BookOpen className="w-5 h-5" />;
    }
  };

  const getTypeColor = (type) => {
    switch (type) {
      case 'video': return 'bg-red-100 text-red-700';
      case 'course': return 'bg-blue-100 text-blue-700';
      case 'docs': return 'bg-green-100 text-green-700';
      case 'article': return 'bg-purple-100 text-purple-700';
      default: return 'bg-gray-100 text-gray-700';
    }
  };

  const getDifficultyColor = (difficulty) => {
    switch (difficulty) {
      case 'Beginner': return 'bg-green-100 text-green-700';
      case 'Intermediate': return 'bg-yellow-100 text-yellow-700';
      case 'Advanced': return 'bg-red-100 text-red-700';
      default: return 'bg-gray-100 text-gray-700';
    }
  };

  return (
    <div className="space-y-6">
      {/* Header */}
      <div>
        <h1 className="text-3xl font-bold text-gray-900">Learning Hub</h1>
        <p className="text-gray-600 mt-2">Curated resources to boost your skills</p>
      </div>

      {/* Quick Stats */}
      <div className="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div className="bg-white rounded-xl p-6 border border-gray-200">
          <div className="text-3xl font-bold text-gray-900">
            {Object.values(resources).flat().length}
          </div>
          <div className="text-sm text-gray-600 mt-1">Total Resources</div>
        </div>
        <div className="bg-white rounded-xl p-6 border border-gray-200">
          <div className="text-3xl font-bold text-gray-900">
            {Object.values(resources).flat().filter(r => r.priority === 'high').length}
          </div>
          <div className="text-sm text-gray-600 mt-1">High Priority</div>
        </div>
        <div className="bg-white rounded-xl p-6 border border-gray-200">
          <div className="text-3xl font-bold text-gray-900">
            {Object.values(resources).flat().filter(r => r.type === 'video' || r.type === 'course').length}
          </div>
          <div className="text-sm text-gray-600 mt-1">Video Courses</div>
        </div>
        <div className="bg-white rounded-xl p-6 border border-gray-200">
          <div className="text-3xl font-bold text-gray-900">
            {Object.values(resources).flat().filter(r => r.type === 'docs').length}
          </div>
          <div className="text-sm text-gray-600 mt-1">Documentation</div>
        </div>
      </div>

      {/* Resources by Category */}
      {Object.entries(resources).map(([category, items]) => (
        <div key={category} className="bg-white rounded-xl p-6 border border-gray-200">
          <h2 className="text-xl font-bold text-gray-900 mb-4 capitalize">
            {category.replace('_', ' ')} Resources
          </h2>
          <div className="space-y-4">
            {items.map((resource, index) => (
              <a
                key={index}
                href={resource.url}
                target="_blank"
                rel="noopener noreferrer"
                className="block p-4 border border-gray-200 rounded-lg hover:border-primary-300 hover:bg-primary-50 transition-all group"
              >
                <div className="flex items-start gap-4">
                  <div className={`p-3 rounded-lg ${getTypeColor(resource.type)}`}>
                    {getTypeIcon(resource.type)}
                  </div>
                  <div className="flex-1">
                    <div className="flex items-start justify-between">
                      <div className="flex-1">
                        <div className="flex items-center gap-2">
                          <h3 className="font-semibold text-gray-900 group-hover:text-primary-600 transition-colors">
                            {resource.title}
                          </h3>
                          <ExternalLink className="w-4 h-4 text-gray-400 group-hover:text-primary-600 transition-colors" />
                        </div>
                        <p className="text-sm text-gray-600 mt-1">{resource.description}</p>
                        <div className="flex items-center gap-3 mt-3">
                          <span className={`px-2 py-1 rounded-full text-xs font-medium ${getDifficultyColor(resource.difficulty)}`}>
                            {resource.difficulty}
                          </span>
                          <span className="flex items-center gap-1 text-xs text-gray-600">
                            <Clock className="w-3 h-3" />
                            {resource.duration}
                          </span>
                          {resource.priority === 'high' && (
                            <span className="flex items-center gap-1 text-xs font-medium text-red-600">
                              <Star className="w-3 h-3 fill-current" />
                              High Priority
                            </span>
                          )}
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </a>
            ))}
          </div>
        </div>
      ))}

      {/* Learning Path Recommendation */}
      <div className="bg-gradient-to-br from-primary-50 to-primary-100 rounded-xl p-6 border border-primary-200">
        <h2 className="text-xl font-bold text-primary-900 mb-4">Recommended Learning Path</h2>
        <div className="space-y-3 text-sm text-primary-800">
          <div className="flex items-start gap-3">
            <div className="w-6 h-6 rounded-full bg-primary-600 text-white flex items-center justify-center font-bold text-xs flex-shrink-0">1</div>
            <div>
              <div className="font-semibold">Start with Testing Basics</div>
              <div className="text-primary-700">Complete Android Testing Codelab → Espresso Guide</div>
            </div>
          </div>
          <div className="flex items-start gap-3">
            <div className="w-6 h-6 rounded-full bg-primary-600 text-white flex items-center justify-center font-bold text-xs flex-shrink-0">2</div>
            <div>
              <div className="font-semibold">Master UI Automator</div>
              <div className="text-primary-700">Read documentation → Build sample project</div>
            </div>
          </div>
          <div className="flex items-start gap-3">
            <div className="w-6 h-6 rounded-full bg-primary-600 text-white flex items-center justify-center font-bold text-xs flex-shrink-0">3</div>
            <div>
              <div className="font-semibold">Learn Performance Tools</div>
              <div className="text-primary-700">Perfetto docs → Android Performance Patterns videos</div>
            </div>
          </div>
          <div className="flex items-start gap-3">
            <div className="w-6 h-6 rounded-full bg-primary-600 text-white flex items-center justify-center font-bold text-xs flex-shrink-0">4</div>
            <div>
              <div className="font-semibold">Practice with Real Projects</div>
              <div className="text-primary-700">Apply skills to your portfolio projects</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
};

export default LearningResources;
