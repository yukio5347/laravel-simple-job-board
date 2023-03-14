import { Link, usePage } from '@inertiajs/react';
import { Search, File } from '@/Components/Icons';

const Layout = ({ children }: { children: React.ReactNode }) => {
  const { appName } = usePage().props;
  return (
    <>
      <header className="bg-sky-500 py-5">
        <div className="flex flex-col md:container md:flex-row md:justify-between">
          <a
            href="{route('home')}"
            className="flex-none text-lg text-center inline-block text-white font-semibold md:text-left"
          >
            {String(appName)}
          </a>
          <div className="flex-1 mt-4 flex justify-between md:items-end md:justify-end md:m-0">
            <a href={route('home')} className="hidden font-medium text-white md:flex items-center justify-center">
              {__('Home')}
            </a>
            <Link
              href={route('jobs.index')}
              className="w-1/2 flex items-center justify-center font-medium text-white md:w-auto md:ml-8 lg:ml-12"
            >
              <Search /> {__('Find Jobs')}
            </Link>
            <Link
              href={route('jobs.create')}
              className="w-1/2 flex items-center justify-center font-medium text-white md:w-auto md:ml-8 lg:ml-12"
            >
              <File /> {__('Post a Job')}
            </Link>
          </div>
        </div>
      </header>
      <main className="container my-10">{children}</main>
      <footer className="bg-slate-800">
        <div className="grid grid-cols-2 gap-5 py-5 text-center md:grid-cols-4 md:container">
          <a href={route('home')} className="text-sm text-center text-white">
            {__('Home')}
          </a>
          <Link href={route('jobs.index')} className="text-sm text-center text-white">
            {__('Find Jobs')}
          </Link>
          <Link href={route('jobs.create')} className="text-sm text-center text-white">
            {__('Post a Job')}
          </Link>
          <Link href={route('contact')} className="text-sm text-center text-white">
            {__('Contact Us')}
          </Link>
        </div>
        <p className="py-3 text-xs text-white text-center border-t border-slate-500">{'© ' + appName}</p>
      </footer>
    </>
  );
};

export default Layout;
