// Data Manager - Handles loading and saving portfolio data

// Use import.meta.env.BASE_URL to get the correct base path
const DATA_URL = `${import.meta.env.BASE_URL}data.json`;

// Load data from JSON file
export const loadData = async () => {
  try {
    const response = await fetch(DATA_URL);
    if (!response.ok) {
      throw new Error('Failed to load data');
    }
    const data = await response.json();
    return data;
  } catch (error) {
    console.error('Error loading data:', error);
    return null;
  }
};

// Save data to localStorage (simulating file save)
// In production, this would make an API call to save to the server
export const saveData = (data) => {
  try {
    localStorage.setItem('portfolioData', JSON.stringify(data));
    console.log('Data saved to localStorage');
    return true;
  } catch (error) {
    console.error('Error saving data:', error);
    return false;
  }
};

// Get data from localStorage if available, otherwise from JSON file
export const getData = async () => {
  const localData = localStorage.getItem('portfolioData');
  if (localData) {
    try {
      return JSON.parse(localData);
    } catch (error) {
      console.error('Error parsing local data:', error);
    }
  }
  return await loadData();
};

// Download data as JSON file
export const downloadData = (data) => {
  const dataStr = JSON.stringify(data, null, 2);
  const dataBlob = new Blob([dataStr], { type: 'application/json' });
  const url = URL.createObjectURL(dataBlob);
  const link = document.createElement('a');
  link.href = url;
  link.download = 'portfolio-data.json';
  document.body.appendChild(link);
  link.click();
  document.body.removeChild(link);
  URL.revokeObjectURL(url);
};

// Reset to original data
export const resetData = async () => {
  localStorage.removeItem('portfolioData');
  return await loadData();
};
