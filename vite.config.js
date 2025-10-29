import { defineConfig } from 'vite'
import react from '@vitejs/plugin-react'

// https://vitejs.dev/config/
export default defineConfig(({ command }) => ({
  plugins: [react()],
  // Use '/' for dev, '/amed12.github.io/' for production
  base: command === 'serve' ? '/' : '/amed12.github.io/',
}))
