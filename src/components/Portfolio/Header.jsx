import { Github, Linkedin, Facebook, Mail, Phone, MapPin, Download, FileText } from 'lucide-react';
import { Link } from 'react-router-dom';

const Header = ({ profile }) => {
  if (!profile) return null;

  return (
    <header className="bg-gradient-to-r from-primary-600 to-primary-800 text-white">
      <div className="container mx-auto px-4 py-16">
        <div className="flex flex-col md:flex-row items-center gap-8">
          {/* Avatar */}
          <div className="w-48 h-48 rounded-full overflow-hidden border-4 border-white shadow-xl flex-shrink-0">
            <img
              src={profile.avatar || '/avatar-placeholder.png'}
              alt={profile.name}
              className="w-full h-full object-cover"
              onError={(e) => {
                e.target.src = 'https://placehold.co/200x200/0ea5e9/ffffff?text=' + profile.name.charAt(0);
              }}
            />
          </div>

          {/* Info */}
          <div className="flex-1 text-center md:text-left">
            <h1 className="text-4xl md:text-5xl font-bold mb-2">{profile.name}</h1>
            <p className="text-xl md:text-2xl text-primary-100 mb-6">{profile.title}</p>

            {/* Contact Info */}
            <div className="grid grid-cols-1 md:grid-cols-2 gap-3 mb-6 text-sm">
              <div className="flex items-center justify-center md:justify-start gap-2">
                <Phone className="w-4 h-4" />
                <a href={`tel:${profile.phone}`} className="hover:text-primary-200">
                  {profile.phone}
                </a>
              </div>
              <div className="flex items-center justify-center md:justify-start gap-2">
                <Mail className="w-4 h-4" />
                <a href={`mailto:${profile.email}`} className="hover:text-primary-200">
                  {profile.email}
                </a>
              </div>
              <div className="flex items-start justify-center md:justify-start gap-2 md:col-span-2">
                <MapPin className="w-4 h-4 mt-1 flex-shrink-0" />
                <span className="text-primary-100">{profile.address}</span>
              </div>
            </div>

            {/* Social Links */}
            <div className="flex gap-4 justify-center md:justify-start mb-6">
              {profile.social?.github && (
                <a
                  href={profile.social.github}
                  target="_blank"
                  rel="noopener noreferrer"
                  className="hover:text-primary-200 transition-colors"
                >
                  <Github className="w-6 h-6" />
                </a>
              )}
              {profile.social?.linkedin && (
                <a
                  href={profile.social.linkedin}
                  target="_blank"
                  rel="noopener noreferrer"
                  className="hover:text-primary-200 transition-colors"
                >
                  <Linkedin className="w-6 h-6" />
                </a>
              )}
              {profile.social?.facebook && (
                <a
                  href={profile.social.facebook}
                  target="_blank"
                  rel="noopener noreferrer"
                  className="hover:text-primary-200 transition-colors"
                >
                  <Facebook className="w-6 h-6" />
                </a>
              )}
            </div>

            {/* CV Buttons */}
            <div className="flex flex-wrap gap-3 justify-center md:justify-start">
              <Link
                to="/cv"
                className="inline-flex items-center gap-2 bg-white text-primary-600 px-6 py-3 rounded-lg font-semibold hover:bg-primary-50 transition-colors"
              >
                <FileText className="w-5 h-5" />
                View ATS CV
              </Link>
              {profile.cvLink && (
                <a
                  href={profile.cvLink}
                  target="_blank"
                  rel="noopener noreferrer"
                  className="inline-flex items-center gap-2 bg-primary-700 text-white px-6 py-3 rounded-lg font-semibold hover:bg-primary-800 transition-colors"
                >
                  <Download className="w-5 h-5" />
                  Download Original CV
                </a>
              )}
            </div>
          </div>
        </div>
      </div>
    </header>
  );
};

export default Header;
