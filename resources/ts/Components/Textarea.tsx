import { forwardRef, useEffect, useRef } from 'react';

const Textarea = (
  { className = '', isFocused = false, ...props }: { className?: string; isFocused?: boolean },
  ref: {
    current: any;
  }
) => {
  const textarea = ref ? ref : useRef();

  useEffect(() => {
    if (isFocused) {
      textarea.current.focus();
    }
  }, []);

  return (
    <div className="flex flex-col items-start">
      <textarea
        {...props}
        className={
          'border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm ' +
          className
        }
        ref={textarea}
      />
    </div>
  );
};

export default forwardRef(Textarea);
