package com.sponline.crud.adapter;

import android.content.Context;
import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.TextView;

import androidx.annotation.NonNull;
import androidx.recyclerview.widget.RecyclerView;

import com.sponline.crud.R;
import com.sponline.crud.model.DataModel;
import android.view.inputmethod.InputMethodManager;

import androidx.fragment.app.FragmentActivity;
import androidx.navigation.NavController;


import java.util.List;

import java.util.List;

public class ReadAdapter extends RecyclerView.Adapter<ReadAdapter.ReadAdapterViewHolder> {
    private static final String TAG = ReadAdapter.class.getName();

    private List<? extends DataModel> dataModels;

    private final FragmentActivity fragmentActivity;
    private final View view;
    private final NavController navController;

    public ReadAdapter( View view1,FragmentActivity fragmentActivity1, NavController navController1) {
        fragmentActivity = fragmentActivity1;
        view = view1;
        navController = navController1;
    }

    public void execute(List<DataModel> DataModels1) {
        dataModels = DataModels1;
    }

    @NonNull
    @Override
    public ReadAdapter.ReadAdapterViewHolder onCreateViewHolder(ViewGroup parent, int viewType) {
        LayoutInflater inflater = LayoutInflater.from(parent.getContext());
        return new ReadAdapter.ReadAdapterViewHolder(inflater.inflate(R.layout.list_layout, parent, false));
    }

    @Override
    public void onBindViewHolder(@NonNull ReadAdapter.ReadAdapterViewHolder holder, final int position) {

        holder.Name.setText(dataModels.get(position).getName());
        holder.Age.setText(dataModels.get(position).getAge());

        holder.itemView.setOnClickListener(v -> {

            InputMethodManager inputMethodManager = (InputMethodManager) fragmentActivity.getSystemService(Context.INPUT_METHOD_SERVICE);
            inputMethodManager.hideSoftInputFromWindow(view.getWindowToken(), 0);

            Bundle bundle = new Bundle();
            bundle.putString("name", dataModels.get(position).getName());
            bundle.putString("personId",dataModels.get(position).getPersonId());
            navController.navigate(R.id.nav_form, bundle);

        });
    }

    public int getItemCount() {
        return dataModels == null ? 0 : dataModels.size();
    }

    static class ReadAdapterViewHolder extends RecyclerView.ViewHolder {

        private final TextView Name;
        private final TextView Age;
        ReadAdapterViewHolder(View view) {
            super(view);
            Name = itemView.findViewById(R.id.name);
            Age = itemView.findViewById(R.id.age);
        }

    }
}
