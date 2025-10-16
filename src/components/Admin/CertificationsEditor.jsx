import { Plus, Trash2 } from 'lucide-react';

const CertificationsEditor = ({ certifications, onChange }) => {
  const addCertification = () => {
    const newCert = {
      id: `cert${Date.now()}`,
      title: '',
      issuer: '',
      date: '',
      link: '',
    };
    onChange([...certifications, newCert]);
  };

  const removeCertification = (id) => {
    onChange(certifications.filter((cert) => cert.id !== id));
  };

  const updateCertification = (id, field, value) => {
    const updated = certifications.map((cert) =>
      cert.id === id ? { ...cert, [field]: value } : cert
    );
    onChange(updated);
  };

  return (
    <div className="space-y-6">
      <div className="flex items-center justify-between">
        <h2 className="text-2xl font-bold">Certifications</h2>
        <button onClick={addCertification} className="btn-primary flex items-center gap-2">
          <Plus className="w-4 h-4" />
          Add Certification
        </button>
      </div>

      <div className="space-y-6">
        {certifications.map((cert) => (
          <div key={cert.id} className="card">
            <div className="flex items-start justify-between mb-4">
              <h3 className="text-lg font-semibold">Certification Entry</h3>
              <button
                onClick={() => removeCertification(cert.id)}
                className="text-red-600 hover:text-red-700"
              >
                <Trash2 className="w-5 h-5" />
              </button>
            </div>

            <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
              <div>
                <label className="block text-sm font-medium text-gray-700 mb-2">Title</label>
                <input
                  type="text"
                  value={cert.title}
                  onChange={(e) => updateCertification(cert.id, 'title', e.target.value)}
                  className="input-field"
                />
              </div>

              <div>
                <label className="block text-sm font-medium text-gray-700 mb-2">Issuer</label>
                <input
                  type="text"
                  value={cert.issuer}
                  onChange={(e) => updateCertification(cert.id, 'issuer', e.target.value)}
                  className="input-field"
                />
              </div>

              <div>
                <label className="block text-sm font-medium text-gray-700 mb-2">Date</label>
                <input
                  type="text"
                  value={cert.date}
                  onChange={(e) => updateCertification(cert.id, 'date', e.target.value)}
                  className="input-field"
                  placeholder="Jan 2020 - Jan 2023"
                />
              </div>

              <div>
                <label className="block text-sm font-medium text-gray-700 mb-2">
                  Certificate Link
                </label>
                <input
                  type="text"
                  value={cert.link}
                  onChange={(e) => updateCertification(cert.id, 'link', e.target.value)}
                  className="input-field"
                  placeholder="https://..."
                />
              </div>
            </div>
          </div>
        ))}
      </div>
    </div>
  );
};

export default CertificationsEditor;
