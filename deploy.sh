#!/bin/bash

# Deploy to GitHub Pages script
echo "Building and deploying to GitHub Pages..."

# Build the project
npm run build

# Deploy to GitHub Pages
npm run deploy

echo "Deployment complete!"
