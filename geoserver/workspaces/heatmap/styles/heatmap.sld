<StyledLayerDescriptor version="1.0.0"
    xsi:schemaLocation="http://www.opengis.net/sld StyledLayerDescriptor.xsd"
    xmlns="http://www.opengis.net/sld"
    xmlns:ogc="http://www.opengis.net/ogc"
    xmlns:xlink="http://www.w3.org/1999/xlink"
    xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
  <NamedLayer>
    <Name>Heatmap</Name>
    <UserStyle>
      <Title>Heatmap</Title>
      <Abstract>A realistic heatmap surface based on point density</Abstract>
      <FeatureTypeStyle>
        <Transformation>
          <ogc:Function name="vec:Heatmap">
            <ogc:Function name="parameter">
              <ogc:Literal>data</ogc:Literal>
            </ogc:Function>
            <ogc:Function name="parameter">
              <ogc:Literal>weightAttr</ogc:Literal>
              <ogc:Literal>geom</ogc:Literal>
            </ogc:Function>
            <ogc:Function name="parameter">
              <ogc:Literal>radiusPixels</ogc:Literal>
              <ogc:Function name="env">
                <ogc:Literal>radius</ogc:Literal>
                <ogc:Literal>250</ogc:Literal>
              </ogc:Function>
            </ogc:Function>
            <ogc:Function name="parameter">
              <ogc:Literal>pixelsPerCell</ogc:Literal>
              <ogc:Literal>10</ogc:Literal>
            </ogc:Function>
            <ogc:Function name="parameter">
              <ogc:Literal>outputBBOX</ogc:Literal>
              <ogc:Function name="env">
                <ogc:Literal>wms_bbox</ogc:Literal>
              </ogc:Function>
            </ogc:Function>
            <ogc:Function name="parameter">
              <ogc:Literal>outputWidth</ogc:Literal>
              <ogc:Function name="env">
                <ogc:Literal>wms_width</ogc:Literal>
              </ogc:Function>
            </ogc:Function>
            <ogc:Function name="parameter">
              <ogc:Literal>outputHeight</ogc:Literal>
              <ogc:Function name="env">
                <ogc:Literal>wms_height</ogc:Literal>
              </ogc:Function>
            </ogc:Function>
          </ogc:Function>
        </Transformation>
        <Rule>
          <RasterSymbolizer>
            <Geometry>
              <ogc:PropertyName>the_geom</ogc:PropertyName>
            </Geometry>
            <Opacity>0.8</Opacity>
            <ColorMap type="ramp">
              <ColorMapEntry color="#FFFFFF" quantity="0" label="No Data" opacity="0"/>
              <ColorMapEntry color="#1E90FF" quantity="0.5" label="Very Low Density" />
              <ColorMapEntry color="#00FF00" quantity="1.0" label="Low Density" />
              <ColorMapEntry color="#FFFF00" quantity="2.0" label="Medium Density" />
              <ColorMapEntry color="#FFA500" quantity="3.0" label="High Density" />
              <ColorMapEntry color="#FF0000" quantity="4.0" label="Very High Density" />
              <ColorMapEntry color="#800000" quantity="5.0" label="Extremely High Density" />
            </ColorMap>
          </RasterSymbolizer>
        </Rule>
      </FeatureTypeStyle>
    </UserStyle>
  </NamedLayer>
</StyledLayerDescriptor>