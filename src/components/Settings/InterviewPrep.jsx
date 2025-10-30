import { Target, BookOpen, MessageSquare, CheckCircle } from 'lucide-react';

const InterviewPrep = ({ data }) => {
  const commonQuestions = [
    {
      category: 'Technical',
      questions: [
        'Explain Clean Architecture and how you\'ve implemented it',
        'Difference between MVVM and MVI patterns',
        'How do you handle memory leaks in Android?',
        'Explain BLoC pattern in Flutter',
        'How do you optimize app performance?'
      ]
    },
    {
      category: 'Behavioral',
      questions: [
        'Tell me about a challenging bug you fixed',
        'How do you handle disagreements with team members?',
        'Describe a time you had to learn a new technology quickly',
        'How do you prioritize tasks in a sprint?',
        'Tell me about a project you\'re most proud of'
      ]
    },
    {
      category: 'System Design',
      questions: [
        'Design a real-time chat application',
        'How would you implement offline-first architecture?',
        'Design a news feed with infinite scroll',
        'Explain your approach to app security',
        'How do you handle API rate limiting?'
      ]
    }
  ];

  const companies = [
    { name: 'Grab GrabKios', focus: 'Flutter, BLoC pattern, Clean Architecture' },
    { name: 'PermataBank', focus: 'React Native, TypeScript, Banking domain' },
    { name: 'ASTRO', focus: 'Performance profiling, Perfetto, Systrace' },
    { name: 'Kredivo', focus: 'Android, Security, Fintech' },
    { name: 'Grab Android', focus: 'Android, Testing, Automated testing' }
  ];

  return (
    <div className="space-y-6">
      <div>
        <h1 className="text-3xl font-bold text-gray-900">Interview Preparation</h1>
        <p className="text-gray-600 mt-2">
          Practice questions and company-specific prep
        </p>
      </div>

      {/* Company Focus Areas */}
      <div className="bg-white rounded-xl p-6 border border-gray-200">
        <h2 className="text-xl font-bold text-gray-900 mb-4">Company Focus Areas</h2>
        <div className="space-y-3">
          {companies.map((company, index) => (
            <div key={index} className="p-4 border border-gray-200 rounded-lg hover:border-primary-300 transition-colors">
              <div className="font-semibold text-gray-900">{company.name}</div>
              <div className="text-sm text-gray-600 mt-1">{company.focus}</div>
            </div>
          ))}
        </div>
      </div>

      {/* Common Questions */}
      <div className="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {commonQuestions.map((category, index) => (
          <div key={index} className="bg-white rounded-xl p-6 border border-gray-200">
            <h3 className="text-lg font-bold text-gray-900 mb-4">{category.category}</h3>
            <div className="space-y-3">
              {category.questions.map((question, qIndex) => (
                <div key={qIndex} className="p-3 bg-gray-50 rounded-lg text-sm text-gray-700">
                  {question}
                </div>
              ))}
            </div>
          </div>
        ))}
      </div>

      {/* STAR Method */}
      <div className="bg-gradient-to-br from-primary-50 to-primary-100 rounded-xl p-6 border border-primary-200">
        <h3 className="text-xl font-bold text-primary-900 mb-4">STAR Method Template</h3>
        <div className="grid grid-cols-1 md:grid-cols-4 gap-4">
          <div className="bg-white rounded-lg p-4">
            <div className="font-bold text-primary-600 mb-2">Situation</div>
            <div className="text-sm text-gray-600">Set the context</div>
          </div>
          <div className="bg-white rounded-lg p-4">
            <div className="font-bold text-primary-600 mb-2">Task</div>
            <div className="text-sm text-gray-600">Describe the challenge</div>
          </div>
          <div className="bg-white rounded-lg p-4">
            <div className="font-bold text-primary-600 mb-2">Action</div>
            <div className="text-sm text-gray-600">Explain what you did</div>
          </div>
          <div className="bg-white rounded-lg p-4">
            <div className="font-bold text-primary-600 mb-2">Result</div>
            <div className="text-sm text-gray-600">Share the outcome</div>
          </div>
        </div>
      </div>
    </div>
  );
};

export default InterviewPrep;
