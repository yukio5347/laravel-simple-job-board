import { useEffect } from 'react';
import { Head, useForm } from '@inertiajs/react';
import Checkbox from '@/Components/Checkbox';
import InputError from '@/Components/InputError';
import InputLabel from '@/Components/InputLabel';
import PrimaryButton from '@/Components/PrimaryButton';
import Textarea from '@/Components/Textarea';
import TextInput from '@/Components/TextInput';
import Select from '@/Components/Select';

const Show = ({
  employmentTypes,
  salaryUnit,
}: {
  employmentTypes: Record<string, string>;
  salaryUnit: Record<string, string>;
}) => {
  const today = new Date();
  const { data, setData, post, processing, errors, reset } = useForm({
    title: '',
    description: '',
    closed_at: new Date(today.setDate(today.getDate() + 30)).toISOString().replace(/T.*/, ''),
    employment_type: 'FULL_TIME',
    address: '',
    locality: '',
    region: '',
    postal_code: '',
    is_remote: true,
    salary_min: 0,
    salary_max: '',
    salary_unit: 'MONTH',
    company_name: '',
    company_description: '',
    name: '',
    email: '',
    password: '',
  });

  useEffect(() => {
    return () => {
      reset('password');
    };
  }, []);

  const handleOnChange = (event: React.ChangeEvent<HTMLInputElement>) => {
    setData(event.target.name, event.target.type === 'checkbox' ? String(event.target.checked) : event.target.value);
  };

  const submit = (event: React.SyntheticEvent) => {
    event.preventDefault();
    post(route('jobs.store'));
  };

  return (
    <>
      <Head title="Register" />

      <form onSubmit={submit}>
        <div>
          <InputLabel htmlFor="title" value="Title" />
          <TextInput
            id="title"
            name="title"
            value={data.title}
            className="mt-1 block w-full"
            isFocused={true}
            onChange={handleOnChange}
            required
          />
          <InputError message={errors.title} className="mt-2" />
        </div>

        <div className="mt-4">
          <InputLabel htmlFor="description" value="description" />
          <Textarea
            id="description"
            name="description"
            value={data.description}
            className="mt-1 block w-full"
            onChange={handleOnChange}
            required
          />
          <InputError message={errors.description} className="mt-2" />
        </div>

        <div className="mt-4">
          <InputLabel htmlFor="closed_at" value="closed_at" />
          <TextInput
            id="closed_at"
            name="closed_at"
            value={data.closed_at}
            className="mt-1 block w-full"
            type="date"
            onChange={handleOnChange}
            required
          />
          <InputError message={errors.closed_at} className="mt-2" />
        </div>

        <div className="mt-4">
          <InputLabel htmlFor="employment_type" value="employment_type" />
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

        <div className="block mt-4">
          <label className="flex items-center">
            <Checkbox name="is_remote" value={data.is_remote} onChange={handleOnChange} />
            <span className="ml-2 text-sm text-gray-600 dark:text-gray-400">Remote job</span>
          </label>
        </div>

        <div className="mt-4">
          <InputLabel htmlFor="address" value="address" />
          <TextInput
            id="address"
            name="address"
            value={data.address}
            className="mt-1 block w-full"
            autoComplete="address"
            onChange={handleOnChange}
          />
          <InputError message={errors.address} className="mt-2" />
        </div>

        <div className="mt-4">
          <InputLabel htmlFor="locality" value="locality" />
          <TextInput
            id="locality"
            name="locality"
            value={data.locality}
            className="mt-1 block w-full"
            onChange={handleOnChange}
          />
          <InputError message={errors.locality} className="mt-2" />
        </div>

        <div className="mt-4">
          <InputLabel htmlFor="region" value="region" />
          <TextInput
            id="region"
            name="region"
            value={data.region}
            className="mt-1 block w-full"
            onChange={handleOnChange}
          />
          <InputError message={errors.region} className="mt-2" />
        </div>

        <div className="mt-4">
          <InputLabel htmlFor="postal_code" value="postal_code" />
          <TextInput
            id="postal_code"
            name="postal_code"
            value={data.postal_code}
            className="mt-1 block w-full"
            onChange={handleOnChange}
          />
          <InputError message={errors.postal_code} className="mt-2" />
        </div>

        <div className="mt-4">
          <InputLabel htmlFor="salary_min" value="salary_min" />
          <TextInput
            id="salary_min"
            name="salary_min"
            value={data.salary_min}
            type="number"
            className="mt-1 block w-full"
            onChange={handleOnChange}
            required
          />
          <InputError message={errors.salary_min} className="mt-2" />
        </div>

        <div className="mt-4">
          <InputLabel htmlFor="salary_max" value="salary_max" />
          <TextInput
            id="salary_max"
            name="salary_max"
            value={data.salary_max}
            type="number"
            className="mt-1 block w-full"
            onChange={handleOnChange}
          />
          <InputError message={errors.salary_max} className="mt-2" />
        </div>

        <div className="mt-4">
          <InputLabel htmlFor="salary_unit" value="salary_unit" />
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

        <div className="mt-4">
          <InputLabel htmlFor="company_name" value="company_name" />
          <TextInput
            id="company_name"
            name="company_name"
            value={data.company_name}
            className="mt-1 block w-full"
            onChange={handleOnChange}
            required
          />
          <InputError message={errors.company_name} className="mt-2" />
        </div>

        <div className="mt-4">
          <InputLabel htmlFor="company_description" value="company_description" />
          <TextInput
            id="company_description"
            name="company_description"
            value={data.company_description}
            className="mt-1 block w-full"
            onChange={handleOnChange}
            required
          />
          <InputError message={errors.company_description} className="mt-2" />
        </div>

        <div className="mt-4">
          <InputLabel htmlFor="name" value="Name" />
          <TextInput
            id="name"
            name="name"
            value={data.name}
            className="mt-1 block w-full"
            autoComplete="name"
            onChange={handleOnChange}
            required
          />
          <InputError message={errors.name} className="mt-2" />
        </div>

        <div className="mt-4">
          <InputLabel htmlFor="email" value="Email" />

          <TextInput
            id="email"
            type="email"
            name="email"
            value={data.email}
            className="mt-1 block w-full"
            autoComplete="name"
            onChange={handleOnChange}
            required
          />

          <InputError message={errors.email} className="mt-2" />
        </div>

        <div className="mt-4">
          <InputLabel htmlFor="password" value="Password" />

          <TextInput
            id="password"
            type="password"
            name="password"
            value={data.password}
            className="mt-1 block w-full"
            autoComplete="new-password"
            onChange={handleOnChange}
            required
          />

          <InputError message={errors.password} className="mt-2" />
        </div>

        <PrimaryButton disabled={processing}>Post</PrimaryButton>
      </form>
    </>
  );
};

export default Show;
