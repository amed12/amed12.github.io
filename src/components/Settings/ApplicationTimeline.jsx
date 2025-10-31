import { useState, useEffect } from 'react';
import { Calendar, CheckCircle, Clock, XCircle, AlertCircle } from 'lucide-react';
import { getApplications, formatDate, getDaysUntil } from '../../utils/storageManager';

const ApplicationTimeline = () => {
  const [applications, setApplications] = useState(getApplications());

  const events = [];
  Object.values(applications).forEach(app => {
    if (app.appliedDate) {
      events.push({
        date: app.appliedDate,
        type: 'applied',
        company: app.company,
        position: app.position,
        status: app.status
      });
    }
    if (app.interviewDate) {
      events.push({
        date: app.interviewDate,
        type: 'interview',
        company: app.company,
        position: app.position,
        status: app.status
      });
    }
    if (app.followUpDate) {
      events.push({
        date: app.followUpDate,
        type: 'followup',
        company: app.company,
        position: app.position,
        status: app.status
      });
    }
  });

  // Sort by date
  events.sort((a, b) => new Date(a.date) - new Date(b.date));

  const upcomingEvents = events.filter(e => getDaysUntil(e.date) >= 0);
  const pastEvents = events.filter(e => getDaysUntil(e.date) < 0);

  const getEventIcon = (type) => {
    switch (type) {
      case 'applied': return <CheckCircle className="w-5 h-5" />;
      case 'interview': return <Calendar className="w-5 h-5" />;
      case 'followup': return <Clock className="w-5 h-5" />;
      default: return <AlertCircle className="w-5 h-5" />;
    }
  };

  const getEventColor = (type) => {
    switch (type) {
      case 'applied': return 'bg-blue-100 text-blue-700 border-blue-300';
      case 'interview': return 'bg-purple-100 text-purple-700 border-purple-300';
      case 'followup': return 'bg-yellow-100 text-yellow-700 border-yellow-300';
      default: return 'bg-gray-100 text-gray-700 border-gray-300';
    }
  };

  const getEventLabel = (type) => {
    switch (type) {
      case 'applied': return 'Applied';
      case 'interview': return 'Interview';
      case 'followup': return 'Follow-up';
      default: return 'Event';
    }
  };

  return (
    <div className="space-y-6">
      {/* Header */}
      <div>
        <h1 className="text-3xl font-bold text-gray-900">Application Timeline</h1>
        <p className="text-gray-600 mt-2">Track your application milestones and upcoming events</p>
      </div>

      {/* Stats */}
      <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div className="bg-white rounded-xl p-6 border border-gray-200">
          <div className="text-3xl font-bold text-gray-900">{events.length}</div>
          <div className="text-sm text-gray-600 mt-1">Total Events</div>
        </div>
        <div className="bg-white rounded-xl p-6 border border-gray-200">
          <div className="text-3xl font-bold text-purple-600">{upcomingEvents.length}</div>
          <div className="text-sm text-gray-600 mt-1">Upcoming</div>
        </div>
        <div className="bg-white rounded-xl p-6 border border-gray-200">
          <div className="text-3xl font-bold text-gray-600">{pastEvents.length}</div>
          <div className="text-sm text-gray-600 mt-1">Past Events</div>
        </div>
      </div>

      {/* Upcoming Events */}
      {upcomingEvents.length > 0 && (
        <div className="bg-white rounded-xl p-6 border border-gray-200">
          <h2 className="text-xl font-bold text-gray-900 mb-4">Upcoming Events</h2>
          <div className="space-y-4">
            {upcomingEvents.map((event, index) => {
              const daysUntil = getDaysUntil(event.date);
              return (
                <div key={index} className="flex items-start gap-4">
                  <div className="flex flex-col items-center">
                    <div className={`p-3 rounded-lg border ${getEventColor(event.type)}`}>
                      {getEventIcon(event.type)}
                    </div>
                    {index < upcomingEvents.length - 1 && (
                      <div className="w-0.5 h-12 bg-gray-300 my-2"></div>
                    )}
                  </div>
                  <div className="flex-1 pb-4">
                    <div className="flex items-start justify-between">
                      <div>
                        <div className="flex items-center gap-2">
                          <h3 className="font-semibold text-gray-900">{event.company}</h3>
                          <span className={`px-2 py-1 rounded-full text-xs font-medium border ${getEventColor(event.type)}`}>
                            {getEventLabel(event.type)}
                          </span>
                        </div>
                        <p className="text-sm text-gray-600 mt-1">{event.position}</p>
                        <div className="text-xs text-gray-500 mt-2">
                          {formatDate(event.date)}
                          {daysUntil === 0 && <span className="ml-2 text-orange-600 font-medium">• Today</span>}
                          {daysUntil > 0 && <span className="ml-2 text-blue-600">• In {daysUntil} days</span>}
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              );
            })}
          </div>
        </div>
      )}

      {/* Past Events */}
      {pastEvents.length > 0 && (
        <div className="bg-white rounded-xl p-6 border border-gray-200">
          <h2 className="text-xl font-bold text-gray-900 mb-4">Past Events</h2>
          <div className="space-y-4">
            {pastEvents.slice().reverse().map((event, index) => {
              const daysAgo = Math.abs(getDaysUntil(event.date));
              return (
                <div key={index} className="flex items-start gap-4 opacity-60">
                  <div className="flex flex-col items-center">
                    <div className={`p-3 rounded-lg border bg-gray-100 text-gray-600 border-gray-300`}>
                      {getEventIcon(event.type)}
                    </div>
                    {index < pastEvents.length - 1 && (
                      <div className="w-0.5 h-12 bg-gray-300 my-2"></div>
                    )}
                  </div>
                  <div className="flex-1 pb-4">
                    <div className="flex items-start justify-between">
                      <div>
                        <div className="flex items-center gap-2">
                          <h3 className="font-semibold text-gray-700">{event.company}</h3>
                          <span className="px-2 py-1 rounded-full text-xs font-medium border bg-gray-100 text-gray-600 border-gray-300">
                            {getEventLabel(event.type)}
                          </span>
                        </div>
                        <p className="text-sm text-gray-600 mt-1">{event.position}</p>
                        <div className="text-xs text-gray-500 mt-2">
                          {formatDate(event.date)} • {daysAgo} days ago
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              );
            })}
          </div>
        </div>
      )}

      {events.length === 0 && (
        <div className="bg-white rounded-xl p-12 border border-gray-200 text-center">
          <Calendar className="w-16 h-16 text-gray-300 mx-auto mb-4" />
          <h3 className="text-lg font-semibold text-gray-900 mb-2">No Events Yet</h3>
          <p className="text-gray-600">
            Start tracking your applications in the Job Tracker to see your timeline here.
          </p>
        </div>
      )}
    </div>
  );
};

export default ApplicationTimeline;
