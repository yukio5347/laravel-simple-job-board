import { useState } from 'react';
import { Link, Head, usePage } from '@inertiajs/react';
import Alert from '@/Components/Alert';
import Pagination from '@/Components/Pagination';
import Modal from '@/Components/Modal';
import { Map, Money, Close } from '@/Components/Icons';
import Paginator from '@/Types/Paginator';
import JobPosting from '@/Types/JobPosting';

const Index = ({ paginator, title, description }: { paginator: Paginator; title: string; description: string }) => {
  const [currentJob, setCurrentJob] = useState(paginator.data[0]);
  const [isOpen, setIsOpen] = useState(false);
  const { message } = usePage().props;
  title += paginator.current_page > 1 ? ' - ' + __('page :page', { page: paginator.current_page }) : '';

  const openModal = (e: React.MouseEvent<HTMLAnchorElement, MouseEvent>, jobPosting: JobPosting): void => {
    e.preventDefault();
    setCurrentJob(jobPosting);
    setIsOpen(true);
  };

  const closeModal = () => {
    setIsOpen(false);
  };

  return (
    <>
      <Head>
        <title>{title}</title>
        <meta name="description" content={description} />
      </Head>
      {message && (
        <Alert>
          <p>{String(message)}</p>
        </Alert>
      )}
      <h1 className="mb-2 font-semibold">{title}</h1>
      {paginator.data.length === 0 ? (
        <p>No jobs found.</p>
      ) : (
        <>
          <div className="grid gap-5 md:grid-cols-2">
            {paginator.data.map((jobPosting: JobPosting, index: number) => (
              <a
                key={index}
                href={route('jobs.show', jobPosting)}
                onClick={(e) => openModal(e, jobPosting)}
                className="flex flex-col justify-between p-4 border rounded-lg transition-colors lg:hover:border-sky-500"
              >
                <div className="flex-1">
                  <h3 className="font-semibold leading-tight mb-1">{jobPosting.title}</h3>
                  <p className="text-sm text-sky-500 font-semibold mb-2">{jobPosting.company_name}</p>
                  {jobPosting.short_work_place && (
                    <p className="flex items-center text-xs text-gray-500 mb-1 home:lg:text-sm">
                      <Map /> {jobPosting.short_work_place}
                    </p>
                  )}
                  {jobPosting.short_salary && (
                    <p className="flex items-center text-xs text-gray-500 mb-1">
                      <Money /> {jobPosting.short_salary}
                    </p>
                  )}
                </div>
                <div className="mt-3 flex justify-between items-center text-xs">
                  <span className={jobPosting.employment_type_color + ' rounded font-medium py-1 px-2'}>
                    {jobPosting.employment_type_text}
                  </span>
                  <div>{dateToString(new Date(jobPosting.created_at))}</div>
                </div>
              </a>
            ))}
          </div>
          <Modal show={isOpen} onClose={closeModal}>
            <div className="relative bg-white p-5 md:p-0 md:rounded-lg">
              <button className="absolute top-1 right-1" onClick={closeModal}>
                <Close />
              </button>
              <div className="flex justify-between pb-5 border-b md:p-7 xl:p-10">
                <div className="flex-1">
                  <h1 className="text-lg font-semibold leading-tight mb-2">{currentJob.title}</h1>
                  <p className="text-sky-500 font-semibold mb-3">{currentJob.company_name}</p>
                  {currentJob.short_work_place && (
                    <p className="flex items-center text-sm text-gray-500 mb-1 home:lg:text-sm">
                      <Map /> {currentJob.work_place}
                    </p>
                  )}
                  {currentJob.short_salary && (
                    <p className="flex items-center text-sm text-gray-500 mb-1">
                      <Money /> {currentJob.salary}
                    </p>
                  )}
                  <div className="mt-3 flex justify-between items-center text-xs">
                    <span className={currentJob.employment_type_color + ' rounded font-medium py-1 px-2'}>
                      {currentJob.employment_type_text}
                    </span>
                    <div>{dateToString(new Date(currentJob.created_at))}</div>
                  </div>
                </div>
              </div>
              <div className="py-5 border-b md:p-7 xl:p-10">
                <h4 className="font-semibold mb-2 text-lg md:mb-4">{__('Job Description')}</h4>
                <p>{nl2br(currentJob.description)}</p>
              </div>
              <div className="py-5 border-b md:p-7 xl:p-10">
                <h4 className="font-semibold mb-2 text-lg md:mb-4">{__('Company Profile')}</h4>
                <p>{nl2br(currentJob.company_description)}</p>
              </div>
              <div className="pt-3 md:p-7 md:py-4 xl:p-10 text-right">
                <Link href={route('jobs.edit', currentJob)} className="mr-5 text-sm text-sky-600" rel="nofollow">
                  {__('Edit')}
                </Link>
                <Link href={route('jobs.destroy.confirm', currentJob)} className="text-sm text-sky-600" rel="nofollow">
                  {__('Delete')}
                </Link>
              </div>
            </div>
            <div className="sticky bottom-0 py-3 text-center bg-white shadow-[0_-3px_5px_-1px_rgba(0,0,0,0.1)]">
              <Link
                href={route('jobs.apply', currentJob)}
                className="p-2 w-60 inline-block rounded-md text-center font-semibold bg-orange-500 text-white transition-colors md:py-3 hover:bg-orange-600"
                rel="nofollow"
              >
                {__('Apply')}
              </Link>
            </div>
          </Modal>
          <Pagination links={paginator.links} />
        </>
      )}
    </>
  );
};

export default Index;
