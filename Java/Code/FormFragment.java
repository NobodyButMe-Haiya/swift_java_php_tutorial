package com.sponline.crud;

import android.os.Bundle;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;

import androidx.annotation.NonNull;
import androidx.annotation.Nullable;
import androidx.appcompat.widget.AppCompatEditText;
import androidx.fragment.app.Fragment;
import androidx.fragment.app.FragmentActivity;
import androidx.navigation.NavController;
import androidx.navigation.Navigation;

import com.sponline.crud.service.CreateService;
import com.sponline.crud.service.UpdateService;

import java.util.Objects;

public class FormFragment extends Fragment {
    private static final String TAG = FormFragment.class.getName();
    AppCompatEditText name;
    AppCompatEditText age;

    public View onCreateView(@NonNull LayoutInflater inflater,
                             ViewGroup container, Bundle savedInstanceState) {

        return inflater.inflate(R.layout.form_layout, container, false);
    }

    @Override
    public void onViewCreated(@NonNull View view, @Nullable Bundle savedInstanceState) {
        final FragmentActivity fragmentActivity = getActivity();
        final NavController navController = Navigation.findNavController(view);
        setToolbar(view, fragmentActivity, navController);

        name = view.findViewById(R.id.nameEditText);
        age = view.findViewById(R.id.ageEditText);
        Bundle bundle = requireArguments();
        if (bundle.containsKey("name")) {
            name.setText(bundle.getString("name"));
        }

        if (bundle.containsKey("age")) {
            age.setText(bundle.getString("age"));

        }
    }

    private void setToolbar(final View view, final FragmentActivity fragmentActivity, final NavController navController) {

        view.findViewById(R.id.homeButton).setOnClickListener(v -> navController.navigate(R.id.nav_list));

        view.findViewById(R.id.saveButton).setOnClickListener(v -> {
            // save Button
            String personId = (requireArguments().containsKey("personId")) ? requireArguments().getString("personId") : null;

            name = view.findViewById(R.id.nameEditText);
            age = view.findViewById(R.id.ageEditText);

            Log.d(TAG, "name : " + Objects.requireNonNull(name.getText()).toString());
            Log.d(TAG, "age" + Objects.requireNonNull(age.getText()).toString());
            Log.d(TAG, "personId:" + personId);

            if (personId == null) {
                // new Record
                // update record
                CreateService createService = new CreateService(view, fragmentActivity);
                createService.execute(Objects.requireNonNull(name.getText()).toString(), Objects.requireNonNull(age.getText()).toString());
                Log.d(TAG, "create");

            } else {
                Log.d(TAG, "personId:" + personId);
                // update record
                UpdateService updateService = new UpdateService(view, fragmentActivity);
                updateService.execute(Objects.requireNonNull(name.getText()).toString(), Objects.requireNonNull(age.getText()).toString(), personId);
                Log.d(TAG, "update");

            }
        });
    }
}
