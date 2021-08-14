package com.sponline.crud.setting;

public enum NetworksConnection {

    LOCAL("https://localhost/crud/simple_oop_proper.php"),
    SERVER("#YourServer");


    private String value;

    NetworksConnection(final String value) {
        this.value = value;
    }

    public String getValue() {
        return value;
    }

    @Override
    public String toString() {
        return this.getValue();
    }
}
