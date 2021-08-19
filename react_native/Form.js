import React, { useState, useEffect } from 'react';
import { Button, View, Text } from 'react-native';
import { useNavigation, useRoute } from '@react-navigation/native';
import { Input } from 'react-native-elements';
import axios from 'axios';

function FormScreen() {
    const navigation = useNavigation();
    const route = useRoute();
    const { nameRoute, ageRoute, personIdRoute } = route.params;


    const [name, onChangeName] = useState('');
    const [age, onChangeAge] = useState('');
    const [personId, onChangePersonId] = useState('');

    // constructor
    useEffect(() => {
        if (nameRoute != null) {
            onChangeName(nameRoute)
            console.log("name route : " + JSON.stringify(nameRoute))
        } else {
            console.log("empty parameter name route")
        }

        if (ageRoute != null) {
            onChangeAge(ageRoute)
            console.log("age route : " + JSON.stringify(ageRoute))
        } else {
            console.log("empty parameter age route")
        }

        if (personIdRoute != null) {
            onChangePersonId(personIdRoute)
            console.log("personId route : " + JSON.stringify(personIdRoute))
        } else {
            console.log("empty parameter person id route")
        }

    }, []);

    function submit() {
        console.log("SUBMIT name = " + name + " age = " + age + " person id" + personId)
        // this totally diff when i used before react-native
        console.log("submit")
        // we will do manually async
        let mode = "create"
        if (personId != null) {
            if (personId > 0) {
                mode = "update";
            }
        }
        // send axios update  request

        var formData = new FormData();
        formData.append("mode",mode);
        formData.append("name",name);
        formData.append("age",age);
        formData.append("personId",personId);

        axios.post('#',formData).then(function (output) {
            console.log("test"+output.data.success)
            if (output.data.success == true) {
                navigation.navigate("List")

            } else {
                // something sweet alert later
            }
        }).catch(function (error) {
            console.log(error)
        });

    }
    return (
        <View>
            <Input
                onChangeText={text => onChangeName(text)}
                value={name.toString()}
                placeholder='Name'
            />
            <Input
                onChangeText={text => onChangeAge(text)}
                value={age.toString()}
                placeholder='Age'
            />
            <Button
                title="Submit"
                onPress={() => {
                    submit()
                }}
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