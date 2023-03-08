import { useState } from 'react';
import { Link } from '@inertiajs/react';
import Pagination from '@/Components/Pagination';
import Paginator from '@/Types/Paginator';
import JobPosting from '@/Types/JobPosting';

const Index = ({ paginator }: { paginator: Paginator }) => {
  const [currentJob, setCurrentJob] = useState(paginator.data[0]);

  const handleClick = (event: React.MouseEvent<HTMLElement>, job: JobPosting): void => {
    event.preventDefault();
    setCurrentJob(job);
  };

  return (
    <>
      <span>jobs.index | page {paginator.current_page}</span>
      {paginator.data.length === 0 ? (
        <p>No jobs found.</p>
      ) : (
        <>
          <ul>
            {paginator.data.map((job: JobPosting, index: number) => (
              <li key={index} className="my-5">
                <a href={route('jobs.show', job)} className="underline" onClick={(event) => handleClick(event, job)}>
                  {job.id}: {job.title}
                </a>
                / <Link href={route('jobs.edit', job)}>Edit</Link>/{' '}
                <Link href={route('jobs.destroy', job)}>Delete</Link>
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
