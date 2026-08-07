import { Link } from 'react-router-dom';
import { AlertTriangle } from 'lucide-react';

const UnpublishedBanner = ({ onDiscard }) => {
  return (
    <div className="bg-yellow-100 border-b border-yellow-300 text-yellow-800 px-4 py-3 flex flex-wrap items-center justify-center gap-3 text-sm">
      <span className="flex items-center gap-2">
        <AlertTriangle className="w-4 h-4" />
        Anda punya perubahan belum dipublish
      </span>
      <button
        onClick={onDiscard}
        className="underline font-medium hover:text-yellow-900"
      >
        Discard
      </button>
      <Link to="/admin" className="underline font-medium hover:text-yellow-900">
        Buka Admin untuk Publish
      </Link>
    </div>
  );
};

export default UnpublishedBanner;
