package com.sponline.crud;

import android.content.SharedPreferences;
import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;

import androidx.annotation.NonNull;
import androidx.annotation.Nullable;
import androidx.appcompat.app.AppCompatActivity;
import androidx.fragment.app.Fragment;
import androidx.fragment.app.FragmentActivity;
import androidx.navigation.NavController;
import androidx.navigation.Navigation;
import androidx.recyclerview.widget.DividerItemDecoration;
import androidx.recyclerview.widget.LinearLayoutManager;
import androidx.recyclerview.widget.RecyclerView;

import com.sponline.crud.adapter.ReadAdapter;
import com.sponline.crud.service.ReadService;

import java.util.Objects;

public class ListFragment extends Fragment {
    private static final String TAG = ListFragment.class.getName();

    public View onCreateView(@NonNull LayoutInflater inflater,
                             ViewGroup container, Bundle savedInstanceState) {

        return inflater.inflate(R.layout.list_layout, container, false);
    }
    @Override
    public void onViewCreated(@NonNull View view, @Nullable Bundle savedInstanceState) {
        final FragmentActivity fragmentActivity = getActivity();
        final NavController navController = Navigation.findNavController(view);

        setReloadToolbar(view, navController);
        getDataFromServer(view, fragmentActivity,navController);
    }
    private void setReloadToolbar(final View view, final NavController navController) {

        view.findViewById(R.id.createButton).setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                navController.navigate(R.id.nav_form);
            }
        });

    }
    private void getDataFromServer(final View view, final FragmentActivity fragmentActivity, final NavController navController) {

        LinearLayoutManager linearLayoutManager = new LinearLayoutManager(fragmentActivity);
        linearLayoutManager.setReverseLayout(true);
        linearLayoutManager.setStackFromEnd(true);

        RecyclerView recyclerView = view.findViewById(R.id.readLists);
        recyclerView.setHasFixedSize(true);
        recyclerView.setLayoutManager(linearLayoutManager);

        // bind form to recycle view
        ReadAdapter readAdapter = new ReadAdapter(view,fragmentActivity,navController);
        recyclerView.setAdapter(readAdapter);

        ReadService readService = new ReadService(view,fragmentActivity,readAdapter);
        readService.execute();

    }
}
