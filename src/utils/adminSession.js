const SESSION_KEY = 'adminUnlocked';

// sessionStorage can throw (private mode, blocked site data); treat that as locked.
export function isAdminUnlocked() {
  try {
    return sessionStorage.getItem(SESSION_KEY) === 'true';
  } catch {
    return false;
  }
}

export function markAdminUnlocked() {
  try {
    sessionStorage.setItem(SESSION_KEY, 'true');
  } catch {
    // Unlock still applies for this page view via component state.
  }
}
