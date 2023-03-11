import { Link, usePage } from '@inertiajs/react';

const Layout = ({ children }: { children: React.ReactNode }) => {
  const { appName } = usePage().props;
  return (
    <>
      <div className="mb-10">
        <Link href="/">{String(appName)}</Link>
        <Link href={route('jobs.index')} className="ml-5">
          Job listing
        </Link>
        <Link href={route('jobs.create')} className="ml-5">
          Post a new job
        </Link>
      </div>
      {children}
    </>
  );
};

export default Layout;
