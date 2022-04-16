import {Table, TableProvider, CTableDeleteLink, useTable} from '@mxjs/a-table';
import {CEditLink, CNewBtn} from '@mxjs/a-clink';
import {Page, PageActions} from '@mxjs/a-page';
import {LinkActions} from '@mxjs/actions';
import {SearchForm, SearchItem} from '@mxjs/a-form';
import {Tag} from 'antd';

const Index = () => {
  const [table] = useTable();

  return (
    <Page>
      <TableProvider>
        <PageActions>
          <CNewBtn/>
        </PageActions>

        <SearchForm>
          <SearchItem label="标题" name={['search', 'title:ct']}/>
        </SearchForm>

        <Table
          tableApi={table}
          columns={[
            {
              title: '分类',
              dataIndex: ['category', 'name'],
            },
            {
              title: '标题',
              dataIndex: 'title',
              render: (value, row) => {
                return (
                  <>
                    {value}
                    {' '}
                    {Object.keys(row.redirectLink).length !== 0 && <Tag>跳转</Tag>}
                  </>
                );
              },
            },
            {
              title: '作者',
              dataIndex: 'author',
            },
            {
              title: '顺序',
              dataIndex: 'sort',
              sorter: true,
            },
            {
              title: '修改时间',
              dataIndex: 'updatedAt',
            },
            {
              title: '操作',
              dataIndex: 'id',
              render: (id) => (
                <LinkActions>
                  <CEditLink id={id}/>
                  <CTableDeleteLink id={id}/>
                </LinkActions>
              ),
            },
          ]}
        />
      </TableProvider>
    </Page>
  );
};

export default Index;
