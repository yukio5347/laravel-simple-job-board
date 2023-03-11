import { Link } from '@inertiajs/react';
import PaginatorLink from '@/Types/PaginatorLink';

const Pagination = ({ links }: { links: PaginatorLink[] }): JSX.Element => {
  function getClassName(active: boolean) {
    let className =
      'mr-1 mb-1 px-4 py-3 text-sm leading-4 border rounded hover:bg-white focus:border-primary focus:text-primary';
    if (active) {
      className += ' bg-blue-700 text-white';
    }
    return className;
  }

  if (links.length <= 3) {
    return <></>;
  }

  return (
    <div className="mb-4">
      <div className="flex flex-wrap mt-8">
        {links.map((link, index) =>
          link.url === null ? (
            <div key={index} className="mr-1 mb-1 px-4 py-3 text-sm leading-4 text-gray-400 border rounded">
              {link.label}
            </div>
          ) : (
            <Link key={index} className={getClassName(link.active)} href={link.url}>
              {link.label}
            </Link>
          )
        )}
      </div>
    </div>
  );
};

export default Pagination;
