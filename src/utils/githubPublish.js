// Publish portfolio data directly to GitHub via the Contents API.
// Token is passed in per-call and never persisted by this module.

const REPO_OWNER = 'amed12';
const REPO_NAME = 'amed12.github.io';
const FILE_PATH = 'public/data.json';
const BRANCH = 'master';

const API_BASE = `https://api.github.com/repos/${REPO_OWNER}/${REPO_NAME}/contents/${FILE_PATH}`;

const toBase64 = (str) => {
  const bytes = new TextEncoder().encode(str);
  const binary = Array.from(bytes, (b) => String.fromCharCode(b)).join('');
  return btoa(binary);
};

const describeError = (status, body) => {
  if (status === 401) return 'Token tidak valid atau sudah expired.';
  if (status === 403) return 'Token tidak punya akses write ke repo ini.';
  if (status === 404) return 'Repo atau file tidak ditemukan.';
  if (status === 409) return 'File berubah di remote sejak load terakhir. Refresh halaman lalu coba lagi.';
  return body?.message || `GitHub API error (status ${status})`;
};

export const publishToGitHub = async ({ token, data, message }) => {
  if (!token) {
    throw new Error('GitHub token wajib diisi.');
  }

  const headers = {
    Authorization: `Bearer ${token}`,
    Accept: 'application/vnd.github+json',
  };

  const getResponse = await fetch(`${API_BASE}?ref=${BRANCH}`, { headers });
  if (!getResponse.ok) {
    const body = await getResponse.json().catch(() => null);
    throw new Error(describeError(getResponse.status, body));
  }
  const { sha } = await getResponse.json();

  const putResponse = await fetch(API_BASE, {
    method: 'PUT',
    headers: { ...headers, 'Content-Type': 'application/json' },
    body: JSON.stringify({
      message: message || 'Update portfolio data via admin panel',
      content: toBase64(JSON.stringify(data, null, 2)),
      sha,
      branch: BRANCH,
    }),
  });

  if (!putResponse.ok) {
    const body = await putResponse.json().catch(() => null);
    throw new Error(describeError(putResponse.status, body));
  }

  return await putResponse.json();
};
