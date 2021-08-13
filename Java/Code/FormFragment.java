package com.sponline.crud;

import android.os.Bundle;
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

public class FormFragment extends Fragment {
    //private static final String TAG = ContactFragment.class.getName();

    public View onCreateView(@NonNull LayoutInflater inflater,
                             ViewGroup container, Bundle savedInstanceState) {

        return inflater.inflate(R.layout.form_layout, container, false);
    }
    @Override
    public void onViewCreated(@NonNull View view, @Nullable Bundle savedInstanceState) {
        final FragmentActivity fragmentActivity = getActivity();
        final NavController navController = Navigation.findNavController(view);
        setToolbar(view, fragmentActivity,navController);

    }
    private void setToolbar(final View view, final FragmentActivity fragmentActivity,final NavController navController) {

        view.findViewById(R.id.homeButton).setOnClickListener(v -> navController.navigate(R.id.nav_list));

        view.findViewById(R.id.saveButton).setOnClickListener(v -> {
            // save Button
            String personId =  requireArguments().getString("personId");

            AppCompatEditText name = view.findViewById(R.id.nameEditText);
            AppCompatEditText age = view.findViewById(R.id.ageEditText);

            if(personId == null){
                // new Record
                // update record
                CreateService createService = new CreateService(view,fragmentActivity);
                createService.execute(name.toString(),age.toString());
            }else {
                // update record
                UpdateService updateService = new UpdateService(view,fragmentActivity);
                updateService.execute(name.toString(),age.toString(),personId);
            }
        });
    }
}
