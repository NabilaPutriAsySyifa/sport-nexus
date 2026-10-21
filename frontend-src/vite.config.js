import { defineConfig } from 'vite';
import react from '@vitejs/plugin-react';
import path from 'path';

export default defineConfig({
  plugins: [react()],
  build: {
    outDir: path.resolve(__dirname, '../assets/js'),
    emptyOutDir: false,
    lib: {
      entry: path.resolve(__dirname, 'index.jsx'),
      name: 'SportNexus',
      formats: ['iife'],
      fileName: () => 'bundle.react.js'
    },
    rollupOptions: {
      output: {
        // inline all dependencies
        extend: true
      }
    }
  },
  define: {
    'process.env.NODE_ENV': JSON.stringify('production')
  }
});
