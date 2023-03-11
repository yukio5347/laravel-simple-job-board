type JobPosting = {
  id: number;
  title: string;
  description: string;
  closed_at: string;
  employment_type: string;
  is_remote: string;
  address: string;
  locality: string;
  region: string;
  postal_code: string;
  salary_min: number;
  salary_max: number;
  salary_unit: string;
  company_name: string;
  company_description: string;
};

export default JobPosting;
