import Index from './index';
import {render} from '@testing-library/react';
import {MemoryRouter} from 'react-router';
import $, {Ret} from 'miaoxing';
import {bootstrap, createPromise, setUrl, resetUrl} from '@mxjs/test';
import {app} from '@mxjs/app';

bootstrap();

describe('admin/articles', () => {
  beforeEach(function () {
    setUrl('admin/articles');
    app.page = {
      collection: 'admin/articles',
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
              title: '测试标题',
              redirectLink: {},
              author: '测试作者',
              sort: 51,
              category: {
                name: '测试分类',
              },
            },
            {
              id: 2,
              title: '测试标题2',
              redirectLink: {
                options: ['articles'],
              },
              author: '测试作者2',
              sort: 52,
            },
          ],
        }),
      }));

    const {findByText} = render(<MemoryRouter>
      <Index/>
    </MemoryRouter>);

    await findByText('测试分类');
    await findByText('测试标题');
    await findByText('图文');
    await findByText('测试作者');
    await findByText(51);

    const redirect = await findByText('跳转');
    expect(redirect.parentElement.getAttribute('data-row-key')).toBe('2');

    await Promise.all([promise]);
    expect($.http).toHaveBeenCalledTimes(1);
    expect($.http).toMatchSnapshot();
  });
});
