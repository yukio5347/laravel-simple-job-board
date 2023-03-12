import { Head, useForm } from '@inertiajs/react';
import InputError from '@/Components/InputError';
import InputLabel from '@/Components/InputLabel';
import PrimaryButton from '@/Components/PrimaryButton';
import Textarea from '@/Components/Textarea';
import TextInput from '@/Components/TextInput';

const Show = () => {
  const { data, setData, post, processing, errors, reset } = useForm({
    name: '',
    email: '',
    message: '',
  });

  const handleOnChange = (event: React.ChangeEvent<HTMLInputElement>) => {
    setData(event.target.name, event.target.value);
  };

  const submit = (event: React.SyntheticEvent) => {
    event.preventDefault();
    post(route('contact'));
  };

  return (
    <>
      <Head title="Contact" />

      <form onSubmit={submit}>
        <div>
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
          <InputLabel htmlFor="message" value="message" />
          <Textarea
            id="message"
            name="message"
            value={data.message}
            className="mt-1 block w-full"
            onChange={handleOnChange}
            required
          />
          <InputError message={errors.message} className="mt-2" />
        </div>

        <PrimaryButton disabled={processing}>Send</PrimaryButton>
      </form>
    </>
  );
};

export default Show;
