package com.example.decatas;

import android.content.Intent;
import android.os.Build;
import android.os.Bundle;

import com.google.android.material.floatingactionbutton.FloatingActionButton;
import com.google.android.material.snackbar.Snackbar;

import androidx.appcompat.app.AppCompatActivity;
import androidx.appcompat.widget.Toolbar;

import android.text.Html;
import android.text.Spanned;
import android.view.View;
import android.widget.TextView;

public class Instrucciones extends AppCompatActivity {

    public TextView bottle,appearance_attributes,smell_attributes,taste_attributes,body_attributes;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_instrucciones);

        bottle = findViewById(R.id.bottle);
        appearance_attributes = findViewById(R.id.appearance_attributes);
        smell_attributes = findViewById(R.id.smell_attributes);
        taste_attributes = findViewById(R.id.taste_attributes);
        body_attributes = findViewById(R.id.body_attributes);

        String s = getResources().getString(R.string.bottle_variable);
        bottle.setText(getSpannedText(s));

        s = getResources().getString(R.string.appearance_attributes);
        appearance_attributes.setText(getSpannedText(s));

        s = getResources().getString(R.string.smell_attributes);
        smell_attributes.setText(getSpannedText(s));

        s = getResources().getString(R.string.taste_attributes);
        taste_attributes.setText(getSpannedText(s));

        s = getResources().getString(R.string.body_attributes);
        body_attributes.setText(getSpannedText(s));
    }

    public void goToLogin(View v){
        Intent intent = new Intent(getApplicationContext(),Login.class);
        startActivity(intent);
    }

    private Spanned getSpannedText(String text) {
        if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.N) {
            return Html.fromHtml(text, Html.FROM_HTML_MODE_COMPACT);
        } else {
            return Html.fromHtml(text);
        }
    }
}