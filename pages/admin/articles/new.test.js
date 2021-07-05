import Page from './new';
import {fireEvent, render, screen, waitFor} from '@testing-library/react';
import {MemoryRouter} from 'react-router';
import {app} from '@mxjs/app';
import $, {Ret} from 'miaoxing';
import {bootstrap, createPromise, setUrl, resetUrl} from '@mxjs/test';

bootstrap();

describe('admin/articles', () => {
  beforeEach(() => {
    setUrl('admin/articles/new');
    app.page = {
      collection: 'admin/articles',
      index: false,
    };
  });

  afterEach(() => {
    resetUrl();
    app.page = {};
  });

  test('form', async () => {
    const promise = createPromise();
    const promise2 = createPromise();
    const promise3 = createPromise();

    $.http = jest.fn()
      // 读取默认数据
      .mockImplementationOnce(() => promise.resolve(Ret.new({
        ret: {
          code: 0,
          data: {
            id: 1,
            categoryId: 1,
            sort: 50,
          },
        },
      })))
      // 读取分类数据
      .mockImplementationOnce(() => promise2.resolve({
        ret: Ret.new({
          code: 0,
          data: [{
            id: 1,
            name: '测试分类',
            children: [],
          }],
        }),
      }))
      // 提交
      .mockImplementationOnce(() => promise3.resolve({
        ret: Ret.new({
          code: 0,
        }),
      }));

    const {getByLabelText} = render(<MemoryRouter>
      <Page/>
    </MemoryRouter>);

    await Promise.all([promise, promise2]);
    expect($.http).toHaveBeenCalledTimes(2);
    expect($.http).toMatchSnapshot();

    // 看到表单加载了数据
    await waitFor(() => expect(getByLabelText('顺序').value).toBe('50'));
    expect(getByLabelText('标题').value).toBe('');

    // 提交表单
    fireEvent.change(getByLabelText('标题'), {target: {value: '测试标题'}});
    fireEvent.click(screen.getByText('提 交'));

    await Promise.all([promise3]);
    expect($.http).toHaveBeenCalledTimes(3);
    expect($.http).toMatchSnapshot();
  });
});
