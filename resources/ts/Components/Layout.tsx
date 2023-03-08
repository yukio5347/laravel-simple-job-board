import { Link, usePage } from '@inertiajs/react';

export default function Layout({ children }: { children: React.ReactNode }) {
  const { appName } = usePage().props;
  return (
    <>
      <div className="mb-10">
        <Link href="/">{String(appName)}</Link>
      </div>
      {children}
    </>
  );
}
