import { Head, useForm } from '@inertiajs/react';
import InputError from '@/Components/InputError';
import InputLabel from '@/Components/InputLabel';
import PrimaryButton from '@/Components/PrimaryButton';
import Textarea from '@/Components/Textarea';
import TextInput from '@/Components/TextInput';

const Show = ({ title, description }: { title: string; description: string }) => {
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
      <Head>
        <title>{title}</title>
        <meta name="description" content={description} />
      </Head>
      <form onSubmit={submit}>
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
          <InputLabel htmlFor="message" value={__('Message')} isRequired={true} />
          <Textarea
            id="message"
            name="message"
            value={data.message}
            className="mt-1 block w-full"
            onChange={handleOnChange}
            maxLength="20000"
            required
          />
          <InputError message={errors.message} className="mt-2" />
        </div>

        <PrimaryButton disabled={processing} className="mt-6">
          {__('Send')}
        </PrimaryButton>
      </form>
    </>
  );
};

export default Show;
