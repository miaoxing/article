import {Component} from 'react';
import {View, Text} from '@fower/taro';
import Ret from '@mxjs/m-ret';
import $ from 'miaoxing';
import RichText from '@mxjs/m-rich-text';

export default class Articles extends Component {
  state = {};

  componentDidMount() {
    $.http({
      url: $.apiUrl('articles/%s', $.req('id')),
      loading: true,
    }).then(({ret}) => {
      if (ret.isErr()) {
        $.ret(ret);
        return;
      }
      this.setState(ret);
    });
  }

  render() {
    const {data = {}} = this.state;

    return (
      <Ret ret={this.state}>
        <Article data={data}/>
      </Ret>
    );
  }
}

const Article = ({data}) => (
  <View pt5 pb4 px4>
    <View mb3 textXL>{data.title}</View>

    <View mb5 textSm gray500>
      {data.author && <Text mr2>
        {data.author}
      </Text>}
      <Text>
        {data.updatedAt.substr(0, 10)}
      </Text>
    </View>

    <RichText leadingRelaxed>{data.detail.content}</RichText>
  </View>
);
