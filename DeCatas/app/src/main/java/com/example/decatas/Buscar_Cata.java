package com.example.decatas;

import android.annotation.SuppressLint;
import android.app.AlertDialog;
import android.content.DialogInterface;
import android.content.Intent;
import android.graphics.Typeface;
import android.graphics.drawable.Drawable;
import android.os.Build;
import android.os.Bundle;

import com.google.android.material.floatingactionbutton.FloatingActionButton;
import com.google.android.material.snackbar.Snackbar;

import androidx.annotation.RequiresApi;
import androidx.appcompat.app.AppCompatActivity;
import androidx.appcompat.widget.Toolbar;

import android.text.InputType;
import android.text.SpannableString;
import android.text.style.ImageSpan;
import android.util.Log;
import android.view.ContextThemeWrapper;
import android.view.Gravity;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.ImageView;
import android.widget.TableLayout;
import android.widget.TableRow;
import android.widget.TextView;
import android.widget.Toast;

import java.net.MalformedURLException;
import java.util.LinkedHashMap;
import java.util.Map;

public class Buscar_Cata extends AppCompatActivity {

    private String idUsuario;
    public EditText inputName;
    public TableLayout table;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_buscar__cata);

        Bundle bundle = getIntent().getExtras();
        idUsuario = bundle.getString("id");

        inputName = (EditText)findViewById(R.id.editTextNombreCata);
        table = (TableLayout)findViewById(R.id.table);
    }

    @SuppressLint("SetTextI18n")
    @RequiresApi(api = Build.VERSION_CODES.LOLLIPOP)
    public void search(View v) throws MalformedURLException {
        table.removeAllViews();
        inputName.setBackgroundResource(R.drawable.input_normal);

        String name = inputName.getText().toString();

        if(name.equals("")){
            Toast.makeText(this, R.string.enter_beer_tasting_name, Toast.LENGTH_LONG).show();
            inputName.setBackgroundResource(R.drawable.input_error);
            return;
        }

        Map<String,String> params = new LinkedHashMap<>();
        params.put("n",name);
        Connection con = new Connection(this,"getCatasByName.php",params);
        while (con.getRes()==null);
        String result = con.getRes();
        if(result.equals("")){
            Toast.makeText(this, R.string.no_beer_tasting_found, Toast.LENGTH_LONG).show();
        }else {
            String[] aux = result.split(";");
            TableRow trTH = new TableRow(this);
            trTH.setGravity(Gravity.CENTER);
            trTH.setLayoutParams(new TableRow.LayoutParams(
                    TableRow.LayoutParams.FILL_PARENT,
                    TableRow.LayoutParams.WRAP_CONTENT));
            trTH.setVisibility(View.VISIBLE);
            TextView tv = new TextView(this);
            tv.setLayoutParams(new TableRow.LayoutParams(
                    TableRow.LayoutParams.FILL_PARENT,
                    TableRow.LayoutParams.WRAP_CONTENT
            ));
            tv.setTypeface(Typeface.DEFAULT, Typeface.BOLD);
            tv.setGravity(Gravity.CENTER);
            tv.setVisibility(View.VISIBLE);
            tv.setPadding(10,10,10,10);
            tv.setTextSize(23);
            tv.setText(R.string.name);
            trTH.addView(tv);

            ImageView icon1 = new ImageView(this);
            icon1.setBackgroundResource(R.drawable.ic_people_foreground);
            icon1.setLayoutParams(new TableRow.LayoutParams(
                    TableRow.LayoutParams.FILL_PARENT,
                    TableRow.LayoutParams.WRAP_CONTENT
            ));
            icon1.getLayoutParams().height=100;
            icon1.getLayoutParams().width=100;
            icon1.setVisibility(View.VISIBLE);
            trTH.addView(icon1);

            ImageView icon2 = new ImageView(this);
            icon2.setBackgroundResource(R.drawable.ic_beer_foreground);
            icon2.setLayoutParams(new TableRow.LayoutParams(
                    TableRow.LayoutParams.FILL_PARENT,
                    TableRow.LayoutParams.WRAP_CONTENT
            ));
            icon2.getLayoutParams().height=100;
            icon2.getLayoutParams().width=100;
            icon2.setVisibility(View.VISIBLE);
            trTH.addView(icon2);

            tv = new TextView(this);
            tv.setLayoutParams(new TableRow.LayoutParams(
                    TableRow.LayoutParams.FILL_PARENT,
                    TableRow.LayoutParams.WRAP_CONTENT
            ));
            tv.setTypeface(Typeface.DEFAULT, Typeface.BOLD);
            tv.setGravity(Gravity.CENTER);
            tv.setVisibility(View.VISIBLE);
            tv.setPadding(10,10,10,10);
            tv.setTextSize(23);
            tv.setText(R.string.join);

            trTH.addView(tv);

            table.addView(trTH);

            for(String c : aux){
                String[] cer = c.split(",");
                String idCata = cer[0];
                String nombreCata = cer[1];
                String nPersonas = cer[2];
                String nCervezas = cer[3];
                TableRow trTD = new TableRow(this);
                trTD.setGravity(Gravity.CENTER);
                trTD.setLayoutParams(new TableRow.LayoutParams(
                        TableRow.LayoutParams.FILL_PARENT,
                        TableRow.LayoutParams.WRAP_CONTENT));
                trTD.setVisibility(View.VISIBLE);
                tv = new TextView(this);
                tv.setLayoutParams(new TableRow.LayoutParams(
                        TableRow.LayoutParams.FILL_PARENT,
                        TableRow.LayoutParams.WRAP_CONTENT
                ));
                tv.setTypeface(Typeface.DEFAULT, Typeface.BOLD);
                tv.setGravity(Gravity.CENTER);
                tv.setVisibility(View.VISIBLE);
                tv.setPadding(10,10,10,10);
                tv.setTextSize(23);
                tv.setText(nombreCata);

                trTD.addView(tv);

                tv = new TextView(this);
                tv.setLayoutParams(new TableRow.LayoutParams(
                        TableRow.LayoutParams.FILL_PARENT,
                        TableRow.LayoutParams.WRAP_CONTENT
                ));
                tv.setTypeface(Typeface.DEFAULT, Typeface.BOLD);
                tv.setGravity(Gravity.CENTER);
                tv.setVisibility(View.VISIBLE);
                tv.setPadding(10,10,10,10);
                tv.setTextSize(23);
                tv.setText(nPersonas);

                trTD.addView(tv);

                tv = new TextView(this);
                tv.setLayoutParams(new TableRow.LayoutParams(
                        TableRow.LayoutParams.FILL_PARENT,
                        TableRow.LayoutParams.WRAP_CONTENT
                ));
                tv.setTypeface(Typeface.DEFAULT, Typeface.BOLD);
                tv.setGravity(Gravity.CENTER);
                tv.setVisibility(View.VISIBLE);
                tv.setPadding(10,10,10,10);
                tv.setTextSize(23);
                tv.setText(nCervezas);

                trTD.addView(tv);

                ImageView img = new ImageView(this);
                img.setLayoutParams(new TableRow.LayoutParams(
                        TableRow.LayoutParams.FILL_PARENT,
                        TableRow.LayoutParams.WRAP_CONTENT
                ));

                img.setVisibility(View.VISIBLE);
                img.setPadding(10,10,10,10);
                img.setTag(idCata);
                img.getLayoutParams().height=150;
                img.getLayoutParams().width=150;
                img.setImageDrawable(getDrawable(R.drawable.ic_add_foreground));
                img.setOnClickListener(new View.OnClickListener() {
                    @Override
                    public void onClick(View v) {
                        String id = (String) v.getTag();
                        try {
                            join(id);
                        } catch (MalformedURLException e) {
                            e.printStackTrace();
                        }
                    }
                });

                trTD.addView(img);

                table.addView(trTD);
            }
        }
    }

    private void join(final String id) throws MalformedURLException {
        final String[] aux = new String[1];
        AlertDialog.Builder builder = new AlertDialog.Builder(this, R.style.Theme_AppCompat_Dialog_Alert);
        builder.setCancelable(true);

        final EditText input = new EditText(this);
        input.setLayoutParams(new TableRow.LayoutParams(
                TableRow.LayoutParams.FILL_PARENT,
                TableRow.LayoutParams.WRAP_CONTENT
        ));
        input.getLayoutParams().width=400;
        input.setInputType(InputType.TYPE_TEXT_VARIATION_PASSWORD);
        input.setBackgroundResource(R.drawable.backgroud);
        input.setPadding(10,0,0,0);
        input.setHeight(150);
        input.setHint(getResources().getString(R.string.prompt_password));
        builder.setView(input);

        builder.setPositiveButton(R.string.ok, new DialogInterface.OnClickListener() {
            @Override
            public void onClick(DialogInterface dialog, int which) {
                aux[0] = input.getText().toString();
                Log.v("join",aux[0]);
                Map<String,String> params = new LinkedHashMap<>();
                params.put("u",idUsuario);
                params.put("c",id);
                params.put("p",aux[0]);
                Connection con = null;
                try {
                    con = new Connection(getApplicationContext(),"joinCata.php",params);
                } catch (MalformedURLException e) {
                    e.printStackTrace();
                }
                while (con.getRes()==null);
                String result = con.getRes();
                if(result.equals("1")){
                    Intent intent = new Intent(getApplicationContext(),Cata.class);
                    intent.putExtra("idUsuario",idUsuario);
                    intent.putExtra("idCata",id);
                    startActivity(intent);
                }else {
                    Toast.makeText(getApplicationContext(), R.string.error_join_beer_tasting, Toast.LENGTH_LONG).show();
                }

            }
        });
        builder.setNegativeButton(R.string.cancel, new DialogInterface.OnClickListener() {
            @Override
            public void onClick(DialogInterface dialog, int which) {
                dialog.cancel();
            }
        });

        builder.show();



    }
}