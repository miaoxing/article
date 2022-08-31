import Index from './index';
import {render} from '@testing-library/react';
import {MemoryRouter} from 'react-router';
import $, {Ret} from 'miaoxing';
import {bootstrap, createPromise, setUrl, resetUrl} from '@mxjs/test';
import {app} from '@mxjs/app';

bootstrap();

describe('admin/article-categories', () => {
  beforeEach(function () {
    setUrl('admin/article-categories');
    app.page = {
      collection: 'admin/article-categories',
      index: true,
    };
  });

  afterEach(() => {
    resetUrl();
    app.page = {};
  });

  test('index', async () => {
    const promise = createPromise();

    $.http = jest.fn()
      // 读取列表数据
      .mockImplementationOnce(() => promise.resolve({
        ret: Ret.suc({
          data: [
            {
              id: 1,
              parentId: 0,
              sort: 50,
              name: '测试分类',
              children: [
                {
                  id: 2,
                  parentId: 1,
                  sort: 50,
                  name: '子分类',
                },
              ],
            },
          ],
        }),
      }));

    const {findByText} = render(<MemoryRouter>
      <Index/>
    </MemoryRouter>);

    await findByText('测试分类');
    await findByText('└ 子分类');

    await Promise.all([promise]);
    expect($.http).toHaveBeenCalledTimes(1);
    expect($.http).toMatchSnapshot();
  });
});
