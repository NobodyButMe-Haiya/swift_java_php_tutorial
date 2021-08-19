import * as React from 'react';
import { Button, View, Text } from 'react-native';
import { NavigationContainer } from '@react-navigation/native';
import { createNativeStackNavigator } from '@react-navigation/native-stack';
import FormScreen from './Form'
import ListScreen from './List'

const Stack = createNativeStackNavigator();

function App() {
    return (
        <NavigationContainer>
            <Stack.Navigator initialRouteName="List">
                <Stack.Screen name="Form" component={FormScreen} />
                <Stack.Screen name="List" component={ListScreen}
                              options={({navigation}) => ({
                                  headerRight: () => <Button title="Create" onPress={() =>     navigation.navigate("Form",{
                                      nameRoute: "",
                                      ageRoute: "",
                                      personIdRoute: ""
                                  })} />,
                              })}
                />
            </Stack.Navigator>
        </NavigationContainer>
    );
}

export default App;