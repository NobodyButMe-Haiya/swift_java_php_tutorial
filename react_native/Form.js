import * as React from 'react';
import { Button, View, Text } from 'react-native';
import { useNavigation } from '@react-navigation/native';
import Icon from 'react-native-vector-icons/FontAwesome';
import { Input } from 'react-native-elements';

function FormScreen() {
  const navigation = useNavigation();

  return (
    <View>
      <Input
        placeholder='Name'
        leftIcon={{ type: 'font-awesome', name: 'chevron-left' }}
      />
      <Input
        placeholder='Age'
        leftIcon={{ type: 'font-awesome', name: 'chevron-left' }}
      />
      <Button
        title="Back"
        onPress={() => {
          navigation.goBack();
        }}
      />
    </View>
  );
}
export default FormScreen;