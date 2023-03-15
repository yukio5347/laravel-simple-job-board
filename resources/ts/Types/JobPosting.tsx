type JobPosting = {
  id: number;
  title: string;
  description: string;
  closed_at: string;
  employment_type: string;
  is_remote: string;
  address: string | null;
  locality: string | null;
  region: string | null;
  postal_code: string | null;
  salary_min: number;
  salary_max: number | null;
  salary_unit: string;
  company_name: string;
  company_description: string;
  created_at: string;
  employment_type_text: string;
  employment_type_color: string;
  salary_unit_text: string;
  short_work_place: string;
  work_place: string;
  short_salary: string;
  salary: string;
};

export default JobPosting;
