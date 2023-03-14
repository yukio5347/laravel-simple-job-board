import './bootstrap';
import '../css/app.css';

import { createRoot } from 'react-dom/client';
import { createInertiaApp } from '@inertiajs/react';
// import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import Layout from '@/Components/Layout';

declare global {
  function route(routeName: string, parameters?: unknown): string;
  function nl2br(str: string): (string | JSX.Element)[];
  function dateToString(date: Date): string;
  function __(key: string, replace?: Record<string, unknown>): string;
}

const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel';

createInertiaApp({
  title: (title) => `${title} - ${appName}`,
  resolve: (name) => {
    // resolvePageComponent(`./Pages/${name}.tsx`, import.meta.glob('./Pages/**/*.tsx', { eager: true })),
    const pages = import.meta.glob('./Pages/**/*.tsx', { eager: true });
    const page = pages[`./Pages/${name}.tsx`];
    page.default.layout = page.default.layout || ((page) => <Layout>{page}</Layout>);
    return page;
  },
  setup({ el, App, props }: { el: any; App: any; props: any }) {
    const translations = props.initialPage.props.translations;

    window.nl2br = (str: string): (string | JSX.Element)[] => {
      const regex = /(\r\n|\r|\n)/g;
      return str.split(regex).map((line, index) => (line.match(regex) ? <br key={index} /> : line));
    };

    window.dateToString = (date: Date): string => {
      return date.toISOString().replace(/T.*/, '');
    };

    window.__ = (key: string, replace?: Record<string, unknown>): string => {
      let translatedText: string = translations.data[translations.locale][key] || key;
      for (const key in replace) {
        const replacedText = String(replace[key as keyof typeof replace]);
        translatedText = translatedText.replace(`:${key}`, replacedText);
      }
      return translatedText;
    };

    const setVh = () => {
      const vh = window.innerHeight * 0.01;
      document.documentElement.style.setProperty('--vh', `${vh}px`);
    };
    window.addEventListener('load', setVh);
    window.addEventListener('resize', setVh);

    const root = createRoot(el);

    root.render(<App {...props} />);
  },
  progress: {
    color: '#4B5563',
  },
});
