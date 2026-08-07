import { useState } from 'react';
import { Lock } from 'lucide-react';

const SESSION_KEY = 'adminUnlocked';

export function isAdminUnlocked() {
  return sessionStorage.getItem(SESSION_KEY) === 'true';
}

export default function AdminGate({ onUnlock }) {
  const [passphrase, setPassphrase] = useState('');
  const [error, setError] = useState('');

  const handleSubmit = (e) => {
    e.preventDefault();
    const expected = import.meta.env.VITE_ADMIN_PASSPHRASE;
    if (!expected) {
      setError('VITE_ADMIN_PASSPHRASE belum diset. Cek SETUP.md.');
      return;
    }
    if (passphrase === expected) {
      sessionStorage.setItem(SESSION_KEY, 'true');
      setError('');
      onUnlock();
    } else {
      setError('Passphrase salah.');
    }
  };

  return (
    <div className="fixed bottom-6 right-6 z-40 bg-white border border-gray-200 rounded-lg shadow-lg p-4 w-72">
      <form onSubmit={handleSubmit}>
        <label className="flex items-center gap-2 text-sm font-medium text-gray-700 mb-1">
          <Lock className="w-4 h-4" />
          Admin Passphrase
        </label>
        <input
          type="password"
          value={passphrase}
          onChange={(e) => setPassphrase(e.target.value)}
          placeholder="Masukkan passphrase"
          className="w-full border border-gray-300 rounded-lg px-3 py-2 mb-2"
          autoComplete="off"
          autoFocus
        />
        {error && <p className="text-sm text-red-600 mb-2">{error}</p>}
        <button type="submit" className="btn-primary w-full" disabled={!passphrase}>
          Unlock
        </button>
      </form>
    </div>
  );
}
