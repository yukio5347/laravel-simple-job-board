import { useState, useEffect } from 'react';
import { Head, useForm } from '@inertiajs/react';
import Checkbox from '@/Components/Checkbox';
import InputError from '@/Components/InputError';
import InputLabel from '@/Components/InputLabel';
import PrimaryButton from '@/Components/PrimaryButton';
import Textarea from '@/Components/Textarea';
import TextInput from '@/Components/TextInput';
import Select from '@/Components/Select';
import JobPosting from '@/Types/JobPosting';

const Show = ({
  jobPosting,
  title,
  description,
  employmentTypes,
  salaryUnit,
}: {
  jobPosting: JobPosting;
  title: string;
  description: string;
  employmentTypes: Record<string, string>;
  salaryUnit: Record<string, string>;
}) => {
  const [isRemote, setIsRemote] = useState(false);
  const today = new Date();
  const { data, setData, post, patch, processing, errors, reset } = useForm({
    title: jobPosting.title ?? 'this is title',
    description: jobPosting.description ?? 'this is description',
    closed_at: dateToString(new Date(jobPosting.closed_at)),
    employment_type: jobPosting.employment_type,
    is_remote: jobPosting.is_remote,
    address: jobPosting.address ?? 'this is address',
    locality: jobPosting.locality ?? 'this is locality',
    region: jobPosting.region ?? 'this is region',
    postal_code: jobPosting.postal_code ?? 'this is postal_code',
    salary_min: jobPosting.salary_min,
    salary_max: jobPosting.salary_max ?? '',
    salary_unit: jobPosting.salary_unit,
    company_name: jobPosting.company_name ?? 'this is company_name',
    company_description: jobPosting.company_description ?? 'this is company_description',
    name: '',
    email: '',
    password: '',
  });

  useEffect(() => {
    return () => {
      reset('password');
    };
  }, []);

  const handleOnChange = (e: React.ChangeEvent<HTMLInputElement>) => {
    setData(e.target.name, e.target.value);
  };

  const toggleIsRemote = (e: React.ChangeEvent<HTMLInputElement>) => {
    setData('is_remote', e.target.checked ? '1' : '');
    setIsRemote(e.target.checked);
  };

  const submit = (event: React.SyntheticEvent) => {
    event.preventDefault();
    if (jobPosting.created_at) {
      patch(route('jobs.update', jobPosting));
    } else {
      post(route('jobs.store'));
    }
  };

  return (
    <>
      <Head>
        <title>{title}</title>
        <meta name="description" content={description} />
      </Head>
      <h1 className="mb-4 font-semibold">{title}</h1>
      <form onSubmit={submit}>
        <div>
          <InputLabel htmlFor="title" value={__('Job Title')} isRequired={true} />
          <TextInput
            id="title"
            name="title"
            value={data.title}
            className="mt-1 block w-full"
            isFocused={true}
            onChange={handleOnChange}
            maxLength="40"
            required
          />
          <InputError message={errors.title} className="mt-2" />
        </div>

        <div className="mt-4">
          <InputLabel htmlFor="description" value={__('Job Description')} isRequired={true} />
          <Textarea
            id="description"
            name="description"
            value={data.description}
            className="mt-1 block w-full"
            onChange={handleOnChange}
            maxLength="20000"
            required
          />
          <InputError message={errors.description} className="mt-2" />
        </div>

        <div className="mt-4">
          <InputLabel htmlFor="closed_at" value={__('Close Date')} isRequired={true} />
          <TextInput
            id="closed_at"
            name="closed_at"
            value={data.closed_at}
            className="mt-1 block w-full"
            type="date"
            onChange={handleOnChange}
            min={dateToString(today)}
            max={dateToString(new Date(today.setDate(today.getDate() + 90)))}
            required
          />
          <InputError message={errors.closed_at} className="mt-2" />
        </div>

        <div className="mt-4">
          <InputLabel htmlFor="employment_type" value={__('Employment Type')} isRequired={true} />
          <Select
            id="employment_type"
            name="employment_type"
            options={employmentTypes}
            value={data.employment_type}
            className="mt-1 block w-full"
            onChange={handleOnChange}
            required
          />
          <InputError message={errors.employment_type} className="mt-2" />
        </div>

        <h3 className="mt-10 font-semibold">{__('Work Place')}</h3>
        <label className="mt-4 inline-flex items-center">
          <Checkbox name="is_remote" onChange={toggleIsRemote} />
          <span className="ml-2 text-sm font-medium">{__('Remote')}</span>
        </label>

        <div className="mt-4">
          <InputLabel htmlFor="address" value={__('Address')} isRequired={!isRemote} />
          <TextInput
            id="address"
            name="address"
            value={data.address}
            className="mt-1 block w-full"
            autoComplete="street-address"
            onChange={handleOnChange}
            maxLength="255"
            required={!isRemote}
          />
          <InputError message={errors.address} className="mt-2" />
        </div>

        <div className="mt-4">
          <InputLabel htmlFor="locality" value={__('City')} isRequired={!isRemote} />
          <TextInput
            id="locality"
            name="locality"
            value={data.locality}
            className="mt-1 block w-full"
            autoComplete="address-level2"
            onChange={handleOnChange}
            maxLength="255"
            required={!isRemote}
          />
          <InputError message={errors.locality} className="mt-2" />
        </div>

        <div className="mt-4">
          <InputLabel htmlFor="region" value={__('Region')} isRequired={!isRemote} />
          <TextInput
            id="region"
            name="region"
            value={data.region}
            className="mt-1 block w-full"
            autoComplete="address-level1"
            onChange={handleOnChange}
            maxLength="255"
            required={!isRemote}
          />
          <InputError message={errors.region} className="mt-2" />
        </div>

        <div className="mt-4">
          <InputLabel htmlFor="postal_code" value={__('Postal Code')} isRequired={!isRemote} />
          <TextInput
            id="postal_code"
            name="postal_code"
            value={data.postal_code}
            className="mt-1 block w-full"
            autoComplete="postal-code"
            onChange={handleOnChange}
            maxLength="255"
            required={!isRemote}
          />
          <InputError message={errors.postal_code} className="mt-2" />
        </div>

        <h3 className="mt-10 font-semibold">{__('Salary')}</h3>
        <div className="mt-4">
          <InputLabel htmlFor="salary_min" value={__('Min. Salary')} isRequired={true} />
          <TextInput
            id="salary_min"
            name="salary_min"
            value={data.salary_min}
            type="number"
            className="mt-1 block w-full"
            onChange={handleOnChange}
            min="0"
            required
          />
          <InputError message={errors.salary_min} className="mt-2" />
        </div>

        <div className="mt-4">
          <InputLabel htmlFor="salary_max" value={__('Max. Salary')} />
          <TextInput
            id="salary_max"
            name="salary_max"
            value={data.salary_max}
            type="number"
            className="mt-1 block w-full"
            onChange={handleOnChange}
            min="0"
          />
          <InputError message={errors.salary_max} className="mt-2" />
        </div>

        <div className="mt-4">
          <InputLabel htmlFor="salary_unit" value={__('Salary Unit')} isRequired={true} />
          <Select
            id="salary_unit"
            name="salary_unit"
            options={salaryUnit}
            value={data.salary_unit}
            className="mt-1 block w-full"
            onChange={handleOnChange}
            required
          />
          <InputError message={errors.salary_unit} className="mt-2" />
        </div>

        <h3 className="mt-10 font-semibold">{__('Company Information')}</h3>
        <div className="mt-4">
          <InputLabel htmlFor="company_name" value={__('Company Name')} isRequired={true} />
          <TextInput
            id="company_name"
            name="company_name"
            value={data.company_name}
            className="mt-1 block w-full"
            autoComplete="organization"
            onChange={handleOnChange}
            maxLength="255"
            required
          />
          <InputError message={errors.company_name} className="mt-2" />
        </div>

        <div className="mt-4">
          <InputLabel htmlFor="company_description" value={__('Company Description')} isRequired={true} />
          <Textarea
            id="company_description"
            name="company_description"
            value={data.company_description}
            className="mt-1 block w-full"
            onChange={handleOnChange}
            maxLength="20000"
            required
          />
          <InputError message={errors.company_description} className="mt-2" />
        </div>

        <h3 className="mt-10 font-semibold">{__('Authentication Information')}</h3>
        {!jobPosting.created_at && (
          <div className="mt-4">
            <InputLabel htmlFor="name" value={__('Your Name')} isRequired={true} />
            <TextInput
              id="name"
              name="name"
              value={data.name}
              className="mt-1 block w-full"
              autoComplete="name"
              onChange={handleOnChange}
              maxLength="255"
              required
            />
            <InputError message={errors.name} className="mt-2" />
          </div>
        )}

        <div className="mt-4">
          <InputLabel htmlFor="email" value={__('Email Address')} isRequired={true} />
          <TextInput
            id="email"
            type="email"
            name="email"
            value={data.email}
            className="mt-1 block w-full"
            autoComplete="email"
            onChange={handleOnChange}
            maxLength="255"
            required
          />
          <InputError message={errors.email} className="mt-2" />
        </div>

        <div className="mt-4">
          <InputLabel htmlFor="password" value={__('Password')} isRequired={true} />
          <TextInput
            id="password"
            type="password"
            name="password"
            value={data.password}
            className="mt-1 block w-full"
            autoComplete="current-password"
            onChange={handleOnChange}
            maxLength="255"
            required
          />
          <InputError message={errors.password} className="mt-2" />
        </div>

        <PrimaryButton disabled={processing} className="mt-6">
          {__('Post')}
        </PrimaryButton>
      </form>
    </>
  );
};

export default Show;
