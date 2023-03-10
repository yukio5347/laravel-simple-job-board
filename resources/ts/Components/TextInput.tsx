import { forwardRef, useEffect, useRef } from 'react';

const TextInput = (
  {
    type = 'text',
    className = '',
    isFocused = false,
    ...props
  }: { type?: string; className?: string; isFocused?: boolean },
  ref: {
    current: any;
  }
) => {
  const input = ref ? ref : useRef();

  useEffect(() => {
    if (isFocused) {
      input.current.focus();
    }
  }, []);

  return (
    <div className="flex flex-col items-start">
      <input
        {...props}
        type={type}
        className={
          'border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm ' +
          className
        }
        ref={input}
      />
    </div>
  );
};

export default forwardRef(TextInput);
