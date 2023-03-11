import { useState } from 'react';
import { Link, usePage } from '@inertiajs/react';
import Pagination from '@/Components/Pagination';
import Paginator from '@/Types/Paginator';
import JobPosting from '@/Types/JobPosting';

const Index = ({ paginator }: { paginator: Paginator }) => {
  const [currentJob, setCurrentJob] = useState(paginator.data[0]);
  const { message } = usePage().props;

  const handleClick = (e: React.MouseEvent<HTMLAnchorElement, MouseEvent>, jobPosting: JobPosting): void => {
    e.preventDefault();
    setCurrentJob(jobPosting);
  };

  return (
    <>
      {message && <div className="alert">{String(message)}</div>}
      <span>jobs.index | page {paginator.current_page}</span>
      {paginator.data.length === 0 ? (
        <p>No jobs found.</p>
      ) : (
        <>
          <ul>
            {paginator.data.map((jobPosting: JobPosting, index: number) => (
              <li key={index} className="my-5">
                <a
                  href={route('jobs.show', jobPosting)}
                  className="underline"
                  onClick={(e) => handleClick(e, jobPosting)}
                >
                  {jobPosting.id}: {jobPosting.title}
                </a>
                / <Link href={route('jobs.edit', jobPosting)}>Edit</Link> /
                <Link href={route('jobs.destroy.confirm', jobPosting)}>Delete</Link> /
                <Link href={route('jobs.apply', jobPosting)}>Apply</Link>
              </li>
            ))}
          </ul>
          <div className="mt-10">
            <p>job detail</p>
            <p>id: {currentJob.id}</p>
            <p>title: {currentJob.title}</p>
            <p>description: {currentJob.description}</p>
          </div>
        </>
      )}
      <Pagination links={paginator.links} />
    </>
  );
};

export default Index;
