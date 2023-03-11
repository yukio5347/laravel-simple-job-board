import JobPosting from '@/Types/JobPosting';
import PaginatorLink from '@/Types/PaginatorLink';

type Paginator = {
  current_page: number;
  data: JobPosting[];
  links: PaginatorLink[];
};

export default Paginator;
