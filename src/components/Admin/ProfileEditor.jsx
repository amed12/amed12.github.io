const ProfileEditor = ({ profile, onChange }) => {
  const handleChange = (field, value) => {
    onChange({
      ...profile,
      [field]: value,
    });
  };

  const handleSocialChange = (platform, value) => {
    onChange({
      ...profile,
      social: {
        ...profile.social,
        [platform]: value,
      },
    });
  };

  return (
    <div className="space-y-6">
      <h2 className="text-2xl font-bold mb-6">Profile Information</h2>

      <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
          <label className="block text-sm font-medium text-gray-700 mb-2">Name</label>
          <input
            type="text"
            value={profile.name}
            onChange={(e) => handleChange('name', e.target.value)}
            className="input-field"
          />
        </div>

        <div>
          <label className="block text-sm font-medium text-gray-700 mb-2">Title</label>
          <input
            type="text"
            value={profile.title}
            onChange={(e) => handleChange('title', e.target.value)}
            className="input-field"
          />
        </div>

        <div>
          <label className="block text-sm font-medium text-gray-700 mb-2">Age</label>
          <input
            type="number"
            value={profile.age}
            onChange={(e) => handleChange('age', parseInt(e.target.value))}
            className="input-field"
          />
        </div>

        <div>
          <label className="block text-sm font-medium text-gray-700 mb-2">Phone</label>
          <input
            type="text"
            value={profile.phone}
            onChange={(e) => handleChange('phone', e.target.value)}
            className="input-field"
          />
        </div>

        <div>
          <label className="block text-sm font-medium text-gray-700 mb-2">Email</label>
          <input
            type="email"
            value={profile.email}
            onChange={(e) => handleChange('email', e.target.value)}
            className="input-field"
          />
        </div>

        <div>
          <label className="block text-sm font-medium text-gray-700 mb-2">Avatar URL</label>
          <input
            type="text"
            value={profile.avatar}
            onChange={(e) => handleChange('avatar', e.target.value)}
            className="input-field"
            placeholder="/avatar.jpg"
          />
        </div>

        <div className="md:col-span-2">
          <label className="block text-sm font-medium text-gray-700 mb-2">Address</label>
          <input
            type="text"
            value={profile.address}
            onChange={(e) => handleChange('address', e.target.value)}
            className="input-field"
          />
        </div>

        <div className="md:col-span-2">
          <label className="block text-sm font-medium text-gray-700 mb-2">Bio</label>
          <textarea
            value={profile.bio}
            onChange={(e) => handleChange('bio', e.target.value)}
            className="input-field"
            rows="4"
          />
        </div>

        <div className="md:col-span-2">
          <label className="block text-sm font-medium text-gray-700 mb-2">CV Link</label>
          <input
            type="text"
            value={profile.cvLink}
            onChange={(e) => handleChange('cvLink', e.target.value)}
            className="input-field"
            placeholder="https://..."
          />
        </div>
      </div>

      <div className="border-t pt-6">
        <h3 className="text-xl font-bold mb-4">Social Links</h3>
        <div className="grid grid-cols-1 md:grid-cols-3 gap-4">
          <div>
            <label className="block text-sm font-medium text-gray-700 mb-2">GitHub</label>
            <input
              type="text"
              value={profile.social?.github || ''}
              onChange={(e) => handleSocialChange('github', e.target.value)}
              className="input-field"
              placeholder="https://github.com/..."
            />
          </div>

          <div>
            <label className="block text-sm font-medium text-gray-700 mb-2">LinkedIn</label>
            <input
              type="text"
              value={profile.social?.linkedin || ''}
              onChange={(e) => handleSocialChange('linkedin', e.target.value)}
              className="input-field"
              placeholder="https://linkedin.com/in/..."
            />
          </div>

          <div>
            <label className="block text-sm font-medium text-gray-700 mb-2">Facebook</label>
            <input
              type="text"
              value={profile.social?.facebook || ''}
              onChange={(e) => handleSocialChange('facebook', e.target.value)}
              className="input-field"
              placeholder="https://facebook.com/..."
            />
          </div>
        </div>
      </div>
    </div>
  );
};

export default ProfileEditor;
