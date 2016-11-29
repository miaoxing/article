describe('articles/1 查看图文', function () {
  before(function () {
    casper.start(casper.config.baseUrl + '/articles/1');
  });

  it('检查标题和内容是否正确', function () {
    casper.then(function () {
      '.article-title'.should.be.inDOM.and.contain.text('测试图文1');
      '.article-detail'.should.be.inDOM.and.contain.text('这是图文的详情1');
    });
  });
});
