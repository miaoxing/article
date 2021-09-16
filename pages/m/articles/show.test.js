import Show from './show';
import {render, waitFor} from '@testing-library/react';
import $, {Ret} from 'miaoxing';
import {createPromise, bootstrap, setUrl, resetUrl} from '@mxjs/test';
import Taro from '@tarojs/taro';

bootstrap();

describe('Show', () => {
  beforeEach(() => {
    setUrl('/articles/show?id=1');
  });

  afterEach(() => {
    resetUrl();
  });

  test('basic', async () => {
    const promise = createPromise();

    $.http = jest.fn()
      .mockImplementationOnce(() => promise.resolve({
        ret: Ret.suc({
          data: {
            title: 'title',
            updatedAt: '2021-01-01 01:01:01',
            detail: {
              content: 'content',
            },
          },
        }),
      }));

    Taro.setBackgroundColor = jest.fn();

    const {container, getByText} = render(<Show/>);

    await waitFor(() => {
      expect(getByText('content')).not.toBeNull();
    });

    expect(container).toMatchSnapshot();
    expect($.http).toMatchSnapshot();
  });
});