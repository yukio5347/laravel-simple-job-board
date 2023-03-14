import { Link } from '@inertiajs/react';
import PaginatorLink from '@/Types/PaginatorLink';

const Pagination = ({ links }: { links: PaginatorLink[] }): JSX.Element => {
  const className = 'mr-2 mb-2 px-4 py-3 text-sm border rounded transition-colors hover:border-sky-500';

  if (links.length <= 3) {
    return <></>;
  }

  return (
    <div className="mb-4">
      <div className="flex flex-wrap mt-8">
        {links.map((link, index) =>
          link.active ? (
            <span key={index} className={className + ' bg-sky-500 border-sky-500 text-white'}>
              {__(link.label)}
            </span>
          ) : (
            link.url && (
              <Link key={index} href={link.url} className={className}>
                {__(link.label)}
              </Link>
            )
          )
        )}
      </div>
    </div>
  );
};

export default Pagination;
